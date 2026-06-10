<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PartieEnCours;
use App\Entity\HeroTemplate; 
use App\Entity\GameHistory;
use App\Entity\EnnemiesTemplate;
use App\Entity\ActiveMonster;
use App\Entity\ItemTemplate;
use App\Entity\InventoryItem;
use App\Entity\UserStats;

use App\Repository\SkillRepository;

final class GameController extends AbstractController
{
    public function isConnected()
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser(); // on récupère le joueur connecté

        if(!$user) { // sinon redirection vers login
            return $this->redirectToRoute('app_login');
        }
    }
    // algorithme de choix d'item en fonction du drop rate
    public function tirageDropRate(array $items)
    {
        // calcul du total des drop rate de chaque item du tableau
        // array_sum additionne tous les elements d'un tableau
        // array_map crée un tableau 
        // fn($i) => $i->getDropRate() est une fonction qui retourne le drop rate d'un item
        $tauxTotal = array_sum(array_map(fn($i) => $i->getDropRate(), $items));
        // genere un nombre aléatoire entre 1 et le total
        $rand = mt_rand(1, $tauxTotal);
        // pour chaque item du tableau, on soustrait son drop rate au tirage aléatoire
        foreach ($items as $item) {
            $rand -= $item->getDropRate(); // si le tirage devient inférieur ou égal à 0, on retourne l'item correspondant
            if ($rand <= 0) return $item; // sinon on continue avec l'item suivant
        }
        return $items[0]; // retourne le premier item du tableau en cas de probleme
    }

    // fonction pour generer du loot apres une victoire
    public function getLootChoices(EnnemiesTemplate $ennemi, EntityManagerInterface $entityManager): array
    {
        // recupere les items en db 
        $repo = $entityManager->getRepository(ItemTemplate::class);
        //creer une liste de choix
        $choices = [];

        // si c'est un boss, on garanti 1 boost 
        if ($ennemi->isBoss() || $ennemi->isSemiBoss()) {
            // parmis les items, cherche ceux dont le type sont des buffs
            $boosts = $repo->findBy(['type' => ['buff_pv', 'buff_ki', 'buff_attack']]);

            // ajoute le boost tiré au sort a la liste de choix
            $choices[] = $this->tirageDropRate($boosts);
        }

        // est-ce que l'ennemi est un boss ? 
        // si oui, alors on donne 2 choix d'items, sinon c'est 3
        $remainingSlots = ($ennemi->isBoss() || $ennemi->isSemiBoss()) ? 2 : 3;
        // cherche les items avec les types non buffs
        $consumables = $repo->findBy(['type' => ['heal', 'ki_restore', 'heal_ki_restore']]);
        
        for ($i = 0; $i < $remainingSlots; $i++) {
            $choices[] = $this->tirageDropRate($consumables);
        }

        shuffle($choices); // mélange l'odre des items
        return $choices;
    }

    

    #[Route('/game', name: 'app_game')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $redirect =  $this->isConnected(); // vérification de la connexion du joueur
        if($redirect) {
            return $redirect; // redirection vers login si pas connecté
        }

        // recupere toutes les infos du joueur connecté
        $user = $this->getUser();
        // verifie si le joueur a déja une partie en cours
        $activeHero = $entityManager->getRepository(PartieEnCours::class)->findOneBy(['user_id' => $user]);

        return $this->render('game/index.html.twig', [
            //si oui on affiche la page de l'arene sinon la page du choix du personnage
            'activeHero' => $activeHero ?? null, 
        ]);
    }

    #[Route('/game/create/{type}', name: 'app_game_create', methods: ['POST'])]
    public function createHero(string $type, EntityManagerInterface $entityManager): Response
    {
        $redirect =  $this->isConnected(); 
        if($redirect) {
            return $redirect; 
        }
        $user = $this->getUser(); 

        // recupere tous les boosts lié au joueur 
        $stats = $entityManager->getRepository(UserStats::class)->findOneBy(['user' => $user]);

        // verifie si le joueur a déja une partie en cours
        $existingHero = $entityManager->getRepository(PartieEnCours::class)->findOneBy(['user' => $user]);
        if ($existingHero) {
            // si oui, on redirige vers l'arene sans creer de nouveau personnage
            return $this->redirectToRoute('app_arena');
        }
        // sinon on récupere le template correspondant au personnage choisi
        $template = $entityManager->getRepository(HeroTemplate::class)->findOneBy(['name' => $type]);

        if (!$template) {
            // sécurité si le teplate n'existe pas
            $this->addFlash('danger', 'Ce personnage n\'existe pas !');
            return $this->redirectToRoute('app_game');
        }

        // crée une nouvelle partie
        $hero = new PartieEnCours();
        
        $hero->setUser($user);
        $hero->setHeroId($template->getId());
        $hero->setName($template->getName());
        $hero->setImagePath($template->getImagePath());
        // permet de crée une date inchangeable au moment de la création de la partie
        $hero->setCreatedAt(new \DateTimeImmutable());
        // ajoute les buffs du joueurs aux stats de base du personnage
        $hero->setHp($template->getBaseHp() + $stats->getBoostPv());
        $hero->setMaxHp($template->getBaseHp() + $stats->getBoostPv());
        $hero->setKi($template->getBaseKi() + $stats->getBoostKi());
        $hero->setMaxKi($template->getBaseKi() + $stats->getBoostKi() ); 
        $hero->setAttack($template->getAttack() + $stats->getBoostAttack());

        // associe les compétences du template au héros créé si le niveau requis est inférieur ou égal à 1
        foreach ($template->getSkills() as $skill) {
            if ($skill->getNiveauRequis() <= 1) {
                $hero->addSkill($skill);
            }
        }


        $hero->setLevel(1);
        $hero->setCurrentWorld(1);
        $hero->setCurrentStage(1);
        $hero->setXp(0);

        // sauvegarde en base de donnée
        $entityManager->persist($hero);
        // envoyer les requetes d'insertion en bdd
        $entityManager->flush();

        return $this->redirectToRoute('app_arena');
    }
    #[Route('/game/restart', name: 'app_game_restart', methods: ['POST'])]
    public function restart(EntityManagerInterface $entityManager, RequestStack $requestStack): Response
    {
        $redirect =  $this->isConnected(); // vérification de la connexion du joueur
        if($redirect) {
            return $redirect; // redirection vers login si pas connecté
        }
        $user = $this->getUser(); 
        $hero = $entityManager->getRepository(PartieEnCours::class)->findOneBy(['user_id' => $user]);

        if ($hero) {
            // suppression du hero en base de donnée
            $hero->setUser(null);   
            
            $entityManager->remove($hero);
            $entityManager->flush();
        }

        // nettoyage de la session pour effacer le monstre en cours de combat
        $requestStack->getSession()->remove('current_monster');
        //remove les buffs actifs aussi
        $requestStack->getSession()->remove('active_buff');

        return $this->redirectToRoute('app_game');
    }
    #[Route('/arena', name: 'app_arena', methods: ['GET'])]
    public function arena(RequestStack $requestStack, SkillRepository $skillRepository, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');

        $hero = $entityManager->getRepository(PartieEnCours::class)->findOneBy(['user_id' => $user]);
        if (!$hero) return $this->redirectToRoute('app_game');

        // recupere le niveau actuel du hero pour générer le monstre adapté
        $world = $hero->getCurrentWorld();
        $stage = $hero->getCurrentStage();

        // empeche le monstre de se régénérer à chaque rafraîchissement grâce à la session
        $session = $requestStack->getSession();
        $monster = $session->get('current_monster');

        if (!$monster) { 
            // recupere tous les templates de monstres 
            $enemyRepo = $entityManager->getRepository(EnnemiesTemplate::class);

            
            if ($stage == 10) { 
                // cherche un ennemi de type boss pour le monde actuel
                $templates = $enemyRepo->findBy(['isBoss' => true, 'world' => $world]);
            } elseif ($stage == 5) { 
                $templates = $enemyRepo->findBy(['isSemiBoss' => true, 'world' => $world]);
            } else { 
                $templates = $enemyRepo->findBy([
                    'isBoss' => false, 
                    'isSemiBoss' => false,
                    'world' => $world
                ]);
            }

            // sécurité si jamais y'a pas d'ennemis en bdd
            if (empty($templates)) {
                $this->addFlash('danger', 'Aucun monstre disponible en base de données !');
                return $this->redirectToRoute('app_game');
            }

            // choisi un ennemi au hasard parmis ceux qui correspondent
            $randomTemplate = $templates[array_rand($templates)];


            // multiplicateur de stat pour que les ennemis soient plus fort en fonction du niveau
            $multiplicateur = 1 + ($world * 0.2) + ($stage  * 0.1);
            $hp = (int) round($randomTemplate->getBaseHp() * $multiplicateur);
            $attack = (int) round($randomTemplate->getBaseAttack() * $multiplicateur);
            $xpReward = (int) round($randomTemplate->getXpReward() * $multiplicateur);

            // on clone le template avec les stats adapatés
            // permet de garder en mémoire le monstre que l'on combat si jamais on quitte la partie
            $monster = new ActiveMonster(
                $randomTemplate->getName(),
                $hp,
                $attack,
                $xpReward,
                $randomTemplate->getImagePath(),
                $randomTemplate->getId()
            );

            // on l'envoie dans la session pour le garder en mémoire pendant le combat
            $session->set('current_monster', $monster);
            
        }

        // recupere les compétences du héros pour pouvoir les afficher
        $heroSkills = $hero->getSkills();
        // recupere l'inventaire 
        $inventory = $entityManager->getRepository(InventoryItem::class)->findBy(['partieEnCours' => $hero]);

        return $this->render('game/arena.html.twig', [
            'hero' => $hero,
            'monster' => $monster,
            'competences' => $heroSkills,
            'inventory' => $inventory,
        ]);
    }

    #[Route('/arena/action/{action}', name: 'app_arena_attack')]
    public function attackAction(string $action, RequestStack $requestStack, EntityManagerInterface $entityManager, SkillRepository $skillRepository): Response
    {
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');

        $hero = $entityManager->getRepository(PartieEnCours::class)->findOneBy(['user' => $user]);
        if (!$hero) return $this->redirectToRoute('app_game');

        $session = $requestStack->getSession();
        $monster = $session->get('current_monster');

        // si on arrive ici sans monstre, on retourne à l'arène
        if (!$monster) {
            return $this->redirectToRoute('app_arena');
        }
        
        $activeBuff = $session->get('active_buff');
        $currentAttack = $hero->getAttack();

        if ($activeBuff && $activeBuff['turns_left'] > 0) {
            $currentAttack += $activeBuff['bonus'];
        }

        // TOUR DU HERO 

        $damageToMonster = 0;

        // si notre action commence par item_
        if (str_starts_with($action, 'item_')) {
            // on extrait l'id de l'item
            $itemId = (int) str_replace('item_', '', $action);
            // chercher en bdd l'item correspondant
            $inventoryItem = $entityManager->getRepository(InventoryItem::class)->find($itemId);

            //verif si l'item existe bien dans notre inventaire
            if ($inventoryItem && $inventoryItem->getPartieEnCours() === $hero) {
                // on recupere l'item en entier (type & valeur)
                $template = $inventoryItem->getItemTemplate();
                $valeur = $template->getValue();

                switch ($template->getType()) {
                    case 'heal':
                        // on se soigne sans dépasser max hp
                        $hero->setHp(min($hero->getMaxHp(), $hero->getHp() + $valeur));
                        $this->addFlash('success', "Vous utilisez {$template->getName()} et récupérez {$valeur} PV !");
                        break;
                    case 'ki_restore':
                        // pareil mais pour le ki
                        $hero->setKi(min($hero->getMaxKi(), $hero->getKi() + $valeur));
                        $this->addFlash('success', "Vous utilisez {$template->getName()} et récupérez {$valeur} de Ki !");
                        break;
                    case 'heal_ki_restore':
                        // les deux en même temps
                        $hero->setHp(min($hero->getMaxHp(), $hero->getHp() + $valeur));
                        $hero->setKi(min($hero->getMaxKi(), $hero->getKi() + $valeur));
                        $this->addFlash('success', "Vous utilisez {$template->getName()} et restaurez vos PV/Ki !");
                        break;
                }

                // on retire l'item de l'inventaire si on en a plusieurs
                if ($inventoryItem->getQuantity() > 1) {
                    $inventoryItem->setQuantity($inventoryItem->getQuantity() - 1);
                } else {
                    // si c'est le dernier on le supprime
                    $entityManager->remove($inventoryItem);
                }
            } else {
                // securité si item introuvable (via l'url)
                $this->addFlash('danger', "Objet introuvable !");
                return $this->redirectToRoute('app_arena');
            }
        } 
        // attaque de base
        elseif ($action === 'attack') {
            $this->addFlash('info', 'Vous attaquez au corps à corps !');
            // un peu de rng pour pas faire toujours les mêmes dégats
            $variation = rand(90, 110) / 100; 
            $damageToMonster = $currentAttack * $variation;
        }
            
        
        // competences
        else {
            // on cherche la compétence dans la base de données
            $skillUtilisee = $skillRepository->findOneBy(['identifiant' => $action]);

            // on vérifie si la compétence existe ET si le héros la possède
            if ($skillUtilisee && $hero->getSkills()->contains($skillUtilisee)) {
                
                // on vérifie le cout en ki
                if ($hero->getKi() < $skillUtilisee->getKiCost()) {
                    $this->addFlash('warning', "Pas assez de Ki pour lancer {$skillUtilisee->getName()} !");
                    return $this->redirectToRoute('app_arena');
                }

                // consomme le ki
                $hero->setKi($hero->getKi() - $skillUtilisee->getKiCost());
                
                switch ($skillUtilisee->getType()) {
                    case 'damage':
                        $skillDamage = $skillUtilisee->getDamage();
                        $damageToMonster = $currentAttack + $skillDamage * $hero->getLevel();
                        $variation = rand(90, 110) / 100;
                        $damageToMonster = $damageToMonster * $variation;
                        $this->addFlash('success', "Vous lancez {$skillUtilisee->getName()} !");
                        break;

                    case 'heal':
                        $healAmount = $skillUtilisee->getDamage(); 
                        $newHp = min($hero->getMaxHp(), $hero->getHp() + $healAmount);
                        $hero->setHp($newHp);
                        
                        $damageToMonster = 0; 

                        $this->addFlash('success', "Vous lancez {$skillUtilisee->getName()} et récupérez {$healAmount} PV !");
                        break;

                    case 'buff':
                        $boostAmount = $skillUtilisee->getDamage();
                        
                        $turns = $skillUtilisee->getDuree();
                        $tourBuffs = 0;
                        
                        $session->set('active_buff', [
                            'name' => $skillUtilisee->getName(),
                            'bonus' => $boostAmount,
                            'turns_left' => $turns
                        ]);
                        
                        $damageToMonster = 0; 

                        $this->addFlash('success', "Vous activez {$skillUtilisee->getName()} ! +{$boostAmount} d'attaque pour {$turns} tours !");
                        break;

                    default:
                        // si in petit malin essaie de passer par l'url
                        $this->addFlash('warning', "Vous utilisez {$skillUtilisee->getName()} mais rien ne se passe.");
                        break;
                }
            } else {
                // encore une fois si il passe par l'url
                $this->addFlash('danger', "Votre héros ne connaît pas cette technique !");
                return $this->redirectToRoute('app_arena');
            }
        }

        // on applique les dégats a l'ennemi
        $monster->setHp($monster->getHp() - $damageToMonster);

        // si l'ennemi est mort
        if ($monster->getHp() <= 0) {
            $this->addFlash('success', 'Vous avez vaincu le ' . $monster->getName() . ' !');
            
            // fonction de gain d'xp (lvl up inclus dans cette fonction)
            $leveledUp = $hero->addXp($monster->getXpReward());
            
            if ($leveledUp) {
                $this->addFlash('success', 'Niveau supérieur ! Vous êtes maintenant niveau ' . $hero->getLevel());
                
                // verif si le hero débloque une nouvelle compétence 
                // peut etre mettre ça dans une fonction a part dans le personnage ?
                $template = $entityManager->getRepository(HeroTemplate::class)->findOneBy(['name' => $hero->getName()]);
                
                if ($template) {
                    foreach ($template->getSkills() as $skill) {
                        if ($skill->getNiveauRequis() === $hero->getLevel() && !$hero->getSkills()->contains($skill)) {
                            $hero->addSkill($skill);
                            $this->addFlash('success', sprintf('Félicitations ! Tu as débloqué la compétence : %s !', $skill->getName()));
                        }
                    }
                }
            }
            
            // on passe au lvl suivant
            $nextStage = $hero->getCurrentStage() + 1;

            if ($nextStage > 10) {
                // changement de monde apres stage 10
                $hero->setCurrentWorld($hero->getCurrentWorld() + 1);
                $hero->setCurrentStage(1);
                $this->addFlash('info', 'Félicitations ! Vous passez au monde ' . $hero->getCurrentWorld() . ' !');
            } else {
                // Sinon, on avance simplement d'un stage
                $hero->setCurrentStage($nextStage);
            }

            // supprime l'ennemi actuel
            $session->remove('current_monster');
            
            // sauvegarde toutes les modifs suite au combat
            $entityManager->flush();
            $idEnnemi = $monster->getTemplateId();
            
            // direction choix du loot
            return $this->redirectToRoute('app_arena_loot', ['id' => $idEnnemi]); 
        }

        // TOUR DU MONSTRE
        $this->addFlash('danger', 'Tour du ' . $monster->getName() . ' !');
        $damageToHero = $monster->getAttack();
        $this->addFlash('danger', $monster->getName() . " attaque, il inflige $damageToHero dégâts!");

        $hero->setHp($hero->getHp() - $damageToHero);

        // on remet le monstre blessé dans la session pour s'en souvenir au prochain clic
        $session->set('current_monster', $monster);

        // si le hero est mort
        if ($hero->getHp() <= 0) {
            $this->addFlash('danger', 'Vous avez été tué ! Votre partie a été effacée.');
            
            $session->remove('current_monster');
            $session->remove('active_buff');

            $history = new GameHistory();
            $history->setUsername($user->getUsername());
            $history->setHeroId($hero->getId());
            

            $history->setStartedAt(method_exists($hero, 'getCreatedAt') && $hero->getCreatedAt() ? $hero->getCreatedAt() : new \DateTimeImmutable());
            $history->setReachedWorld($hero->getCurrentWorld());
            $history->setReachedStage($hero->getCurrentStage());
            $history->setFinishedAt(new \DateTimeImmutable());

            $hero->setUser(null);
            $entityManager->persist($history);
            $entityManager->remove($hero); 
            $entityManager->flush();

            return $this->redirectToRoute('app_game'); 
        }

        if ($activeBuff) {
            $activeBuff['turns_left']--;

            if ($activeBuff['turns_left'] <= 0) {
                $this->addFlash('warning', "L'effet de {$activeBuff['name']} est terminé.");
                $session->remove('active_buff');
            } else {
                $session->set('active_buff', $activeBuff);
            }
        }

        // On sauvegarde juste la perte de PV du héros en base de données
        $entityManager->flush();

        return $this->redirectToRoute('app_arena');
    }

    #[Route('/arena/loot/{id}', name: 'app_arena_loot')]
    public function loot(int $id, EntityManagerInterface $entityManager): Response
    {
        $ennemi = $entityManager->getRepository(EnnemiesTemplate::class)->find($id); 

        if (!$ennemi) {
            return $this->redirectToRoute('app_arena');
        }

        $choices = $this->getLootChoices($ennemi, $entityManager);

        return $this->render('game/loot.html.twig', [
            'choices' => $choices,
        ]);
    }
    #[Route('/arena/loot/select/{id}', name: 'app_arena_loot_select', methods: ['POST'])]
    public function selectLoot(ItemTemplate $item, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        
        // si c'est un boost de compte
        if (str_starts_with($item->getType(), 'buff_')) {
            $stats = $entityManager->getRepository(UserStats::class)->findOneBy(['user' => $user]);
            $hero = $entityManager->getRepository(PartieEnCours::class)->findOneBy(['user' => $user]);

            switch ($item->getType()) {
                case 'buff_pv': 
                    $stats->setBoostPv($stats->getBoostPv() + $item->getValue()); 
                    if ($hero) {
                        $hero->setMaxHp($hero->getMaxHp() + $item->getValue());
                        $hero->setHp($hero->getHp() + $item->getValue());
                    }
                    break;
                case 'buff_ki': 
                    $stats->setBoostKi($stats->getBoostKi() + $item->getValue()); 
                    if ($hero) {
                        $hero->setMaxKi($hero->getMaxKi() + $item->getValue());
                        $hero->setKi($hero->getKi() + $item->getValue());
                    }
                    break;
                case 'buff_attack': 
                    $stats->setBoostAttack($stats->getBoostAttack() + $item->getValue()); 
                    if ($hero) {
                        $hero->setAttack($hero->getAttack() + $item->getValue());
                    }
                    break;
            }
            $entityManager->flush();
            $this->addFlash('success', 'Boost de compte ' . $item->getName() . ' activé pour cette partie et les suivantes !');
        }
         
        // si c'est un item
        else {
            $hero = $entityManager->getRepository(PartieEnCours::class)->findOneBy(['user' => $user]);

            if ($hero) {
                // on cherche si le joueur a déja cet item
                $existingInventoryItem = $entityManager->getRepository(InventoryItem::class)->findOneBy([
                    'partieEnCours' => $hero,
                    'itemTemplate' => $item
                ]);

                if ($existingInventoryItem) {
                    // si oui on fait +1
                    $existingInventoryItem->setQuantity($existingInventoryItem->getQuantity() + 1);
                } else {
                    // sinon on le crée
                    $newItem = new InventoryItem();
                    $newItem->setPartieEnCours($hero); 
                    $newItem->setItemTemplate($item);   
                    $newItem->setQuantity(1);
                    $entityManager->persist($newItem);
                }

                $entityManager->flush();

                $this->addFlash('success', $item->getName() . ' ajouté à votre inventaire !');
            }
        }

        return $this->redirectToRoute('app_arena');
    }
}
