<?php

use CMW\Manager\Security\SecurityManager;

$title = "Gestion des Récompenses";
$description = "Page de gestion des récompenses";
?>
<h3><i class="fa-solid fa-award"></i> Gestion des Récompenses</h3>

<div class="grid-2">
    <div class="card">
        <form method="post" action="/cmw-admin/dailyloot/manage">
            <?php (new SecurityManager())->insertHiddenToken(); ?>
            <div class="space-y-4">
                <h6>Ajouter une nouvelle récompense</h6>
                <div>
                    <label for="reward_name">Nom de la récompense :</label>
                    <div class="input-group">
                        <i class="fa-solid fa-award"></i>
                        <input type="text" id="reward_name" name="reward_name" required placeholder="Nom de la récompense">
                    </div>
                </div>
                <div>
                    <label for="rarity">Rareté :</label>
                    <div class="input-group">
                        <i class="fa-solid fa-star"></i>
                        <input type="text" id="rarity" name="rarity" required placeholder="Rareté">
                    </div>
                </div>
                <div>
                    <label for="probability">Probabilité (%) :</label>
                    <div class="input-group">
                        <i class="fa-solid fa-percent"></i>
                        <input type="number" id="probability" name="probability" step="1.0" required placeholder="Probabilité">
                    </div>
                </div>
                <div>
                    <label for="command">Commande Minecraft :</label>
                    <div class="input-group">
                        <i class="fa-solid fa-terminal"></i>
                        <input type="text" id="command" name="command" required placeholder="Commande Minecraft">
                    </div>
                </div>
                <div>
                    <label for="image">URL de l'image :</label>
                    <div class="input-group">
                        <i class="fa-solid fa-image"></i>
                        <input type="text" name="image" id="image" placeholder="https://minecraft.wiki/images/Diamond_JE3_BE3.png?99d00">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-center btn-primary">
                Ajouter
            </button>
        </form>
    </div>

    <div class="card">
        <h6>Liste des récompenses</h6>
        <div class="table-container">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Rareté</th>
                        <th>Probabilité</th>
                        <th>Commande</th>
                        <th>Image</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rewards)): ?>
                        <?php foreach ($rewards as $reward): ?>
                            <tr>
                                <td><?= htmlspecialchars($reward['name']) ?></td>
                                <td><?= htmlspecialchars($reward['rarity']) ?></td>
                                <td><?= htmlspecialchars($reward['probability']) ?>%</td>
                                <td><?= htmlspecialchars($reward['command']) ?></td>
                                <td>
                                    <?php if (!empty($reward['image'])): ?>
                                        <img src="<?= htmlspecialchars($reward['image']) ?>" alt="<?= htmlspecialchars($reward['name']) ?>" style="max-width:50px;">
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td class="text-center space-x-2">
                                    <button data-modal-toggle="modal-edit-<?= $reward['id'] ?>" type="button">
                                        <i class="fa-solid fa-pen-to-square text-info"></i>
                                    </button>
                                    <div id="modal-edit-<?= $reward['id'] ?>" class="modal-container">
                                        <div class="modal" style="background-color: #111828">
                                            <div class="modal-header">
                                                <h6>Modifier la récompense <?= htmlspecialchars($reward['name']) ?></h6>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="/cmw-admin/dailyloot/manage/edit">
                                                    <?php (new SecurityManager())->insertHiddenToken(); ?>
                                                    <input type="hidden" name="reward_id" value="<?= $reward['id'] ?>">
                                                    <div class="space-y-4">
                                                        <div>
                                                            <label for="reward_name_edit_<?= $reward['id'] ?>">Nom de la récompense :</label>
                                                            <div class="input-group">
                                                                <i class="fa-solid fa-award"></i>
                                                                <input type="text" id="reward_name_edit_<?= $reward['id'] ?>" name="reward_name" required placeholder="Nom de la récompense" value="<?= htmlspecialchars($reward['name']) ?>">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="rarity_edit_<?= $reward['id'] ?>">Rareté :</label>
                                                            <div class="input-group">
                                                                <i class="fa-solid fa-star"></i>
                                                                <input type="text" id="rarity_edit_<?= $reward['id'] ?>" name="rarity" required placeholder="Rareté" value="<?= htmlspecialchars($reward['rarity']) ?>">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="probability_edit_<?= $reward['id'] ?>">Probabilité (%) :</label>
                                                            <div class="input-group">
                                                                <i class="fa-solid fa-percent"></i>
                                                                <input type="number" id="probability_edit_<?= $reward['id'] ?>" name="probability" step="1.0" required placeholder="Probabilité" value="<?= htmlspecialchars($reward['probability']) ?>">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="command_edit_<?= $reward['id'] ?>">Commande Minecraft :</label>
                                                            <div class="input-group">
                                                                <i class="fa-solid fa-terminal"></i>
                                                                <input type="text" id="command_edit_<?= $reward['id'] ?>" name="command" required placeholder="Commande Minecraft" value="<?= htmlspecialchars($reward['command']) ?>">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="image_edit_<?= $reward['id'] ?>">URL de l'image :</label>
                                                            <div class="input-group">
                                                                <i class="fa-solid fa-image"></i>
                                                                <input type="text" id="image_edit_<?= $reward['id'] ?>" name="image" placeholder="https://minecraft.wiki/images/Diamond_JE3_BE3.png?99d00" value="<?= htmlspecialchars($reward['image']) ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn-center btn-success">
                                                        Modifier
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <button data-modal-toggle="modal-delete-<?= $reward['id'] ?>" type="button">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </button>
                                    <div id="modal-delete-<?= $reward['id'] ?>" class="modal-container">
                                        <div class="modal">
                                            <div class="modal-header-danger">
                                                <h6>Supprimer la récompense <?= htmlspecialchars($reward['name']) ?></h6>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer cette récompense ?
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="/cmw-admin/dailyloot/manage/remove">
                                                    <?php (new SecurityManager())->insertHiddenToken(); ?>
                                                    <input type="hidden" name="reward_id" value="<?= $reward['id'] ?>">
                                                    <button type="submit" class="btn-danger">
                                                        <i class="fa-solid fa-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucune récompense enregistrée</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>