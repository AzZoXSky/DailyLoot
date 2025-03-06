<?php

use CMW\Utils\Website;
use CMW\Model\Core\ThemeModel;
use CMW\Controller\Users\UsersController;
use CMW\Controller\Users\UsersSessionsController;

Website::setTitle('DailyLoot');
Website::setDescription('Chaque jour une récompense unique');
?>

<section class="relative text-white border-t-2">
    <img src="<?= ThemeModel::getInstance()->fetchImageLink('hero_img_bg') ?>"
         class="absolute h-full inset-0 object-center object-cover w-full"
         alt="Vous devez upload bg.webp depuis votre panel !"
         width="1080" height="720" />
    <div class="container mx-auto px-4 py-20 relative">
        <div class="flex flex-wrap -mx-4">
            <div class="mx-auto px-4 text-center w-full lg:w-8/12">
                <h1 class="font-extrabold mb-4 text-2xl md:text-6xl">DailyLoot</h1>
                <p class="font-light mb-6 text-xl">Chaque jour une récompense unique</p>
            </div>
        </div>
    </div>
</section>
<section class="border-t-2 bg-az-header"></section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
  .raffle-roller {
    width: 90%;
    height: 156px;
    position: relative;
    margin: 60px auto 30px auto;
  }
  .raffle-roller-holder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    height: 156px;
    width: 100%;
    overflow: hidden;
    border-radius: 2px;
    border: 1px solid #3c3759;
  }
  .raffle-roller-container {
    width: 9999999999999999999px;
    max-width: 999999999999999999px;
    height: 156px;
    background: rgba(36, 42, 68, 0.86);
    margin-left: 0;
    transition: all 8s cubic-bezier(.08, .6, 0, 1);
  }
  .raffle-roller-holder:before {
    content: "";
    position: absolute;
    border: none;
    z-index: 12222225;
    width: 5px;
    height: 100%;
    left: 50%;
    background: #d16266;
  }
  .item {
  display: inline-block;
  width: 148px;
  height: 148px;
  background-size: cover;
  margin: 5px;
  box-sizing: border-box;
  border: 1px solid #ccc; 
}
</style>

<!-- ------------------------------------------------- Azuria-PvP DailyLoot ------------------------------------------------- -->
<section class="py-8">
  <div class="container mx-auto px-1 mt-4">
    <div class="md:grid gap-8 justify-center items-center text-center">
      <div class="az-news-crates-btn">
        <a href="#" id="openReward" class="text-white rounded-lg btn-azuria-crates-info bg-blue-500 hover:bg-blue-600 px-4 py-2">
          <i class="fa-solid fa-circle-info"></i> Récupérer votre récompense journalière
        </a>
      </div>
    </div>
    
    <div id="reward" class="hidden mt-6 text-white">
      <div class="raffle-roller">
        <div class="raffle-roller-holder">
          <div class="raffle-roller-container" style="margin-left: 0px;"></div>
        </div>
      </div>
      <center>
        <span style="font-size: 16px; color: red; text-decoration: underline;">
          Veuillez être connecté sur Azuria-PvP lorsque vous récupérerez votre récompense
        </span>
        <br>
        <button id="goBtn" onclick="generate(1);" class="bg-blue-800 hover:bg-blue-600 text-white px-4 py-2 rounded mt-2">
          Go
        </button>
      </center>
      <br>
      <div class="inventory"></div>
    </div>
  </div>
</section>

<script>
  // 1) BDD en JSON :
  var allRewards = <?= json_encode($rewardsList, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

  // 2) Gestion de l'affichage du bloc "reward"
  document.addEventListener('DOMContentLoaded', function() {
    const openReward = document.getElementById('openReward');
    const reward = document.getElementById('reward');

    openReward.addEventListener('click', function(e) {
      e.preventDefault();
      reward.classList.remove('hidden');
    });
  });

  // 3) Fonction qui pioche une récompense selon la colonne "probability"
  function pickRewardByProbability(rewards) {
    let totalWeight = 0;
    for (let i = 0; i < rewards.length; i++) {
      totalWeight += parseFloat(rewards[i].probability);
    }

    let random = Math.random() * totalWeight;
    for (let i = 0; i < rewards.length; i++) {
      random -= parseFloat(rewards[i].probability);
      if (random <= 0) {
        return rewards[i];
      }
    }
    // Sécurité : on renvoie la dernière si on dépasse pas
    return rewards[rewards.length - 1];
  }

  function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }

  // 4) Génération de la roulette et animation
  function generate(ng) {
    var goButton = document.getElementById("goBtn");
    if (goButton.disabled) return;
    goButton.disabled = true;
    
    var container = $('.raffle-roller-container');
    container.css({
      transition: "none",
      "margin-left": "0px"
    }).html('');
    
    if ($('#result').length === 0) {
      $('.raffle-roller').before('<div id="result" style="font-size:18px; margin-bottom:10px;"></div>');
    } else {
      $('#result').html('');
    }
    
    // On crée 101 "cases" dans la roulette
    var totalSlots = 101;
    var winningIndex = Math.floor(Math.random() * totalSlots);
    var winningItemData = null;
    
    for (var i = 0; i < totalSlots; i++) {
      // Pioche d'une récompense en respectant la colonne probability
      var rewardItem = pickRewardByProbability(allRewards);

      if (i === winningIndex) {
        winningItemData = rewardItem;
      }
      // Création de la case avec l'image de la récompense
      var element = `
        <div id="CardNumber${i}" class="item"
             style="background-image:url('${rewardItem.image}');">
        </div>
      `;
      container.append(element);
    }
    
    // Calcul pour centrer la case "gagnante"
    var holderWidth = $('.raffle-roller-holder').width();
    var itemWidth = $('.item').outerWidth(true);
    var offset = winningIndex * itemWidth - (holderWidth / 2 - itemWidth / 2);
    
    // Animation de la roulette
    setTimeout(function() {
      container.css({
        transition: "all 8s cubic-bezier(.08,.6,0,1)",
        "margin-left": -offset + "px"
      });

      // Après 8,5s, on affiche le résultat
      setTimeout(function() {
        $('#result').html(`
          <div class="flex justify-center items-center text-center space-x-2 lg:space-x-6">
            <img class="lg:inline mr-2" loading="lazy" alt="player head" width="32px"
                 src="https://apiv2.craftmywebsite.fr/skins/3d/user=<?= UsersSessionsController::getInstance()->getCurrentUser()?->getPseudo() ?>&headOnly=true">
            <div>
              Félicitation ! <?= UsersSessionsController::getInstance()->getCurrentUser()->getPseudo() ?>
              Vous avez gagné : ${winningItemData.name}
            </div>
          </div>
        `);
        goButton.disabled = false;
      }, 8500);
    }, 100);
  }
</script>
