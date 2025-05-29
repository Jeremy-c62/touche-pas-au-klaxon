<?php
// Redirection si non connecté
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/auth/login');
    exit;
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Tableau de bord - Utilisateur</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">Touche pas au klaxon</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-white">Bienvenue, <?= htmlspecialchars($user['prenom']) ?></span>
        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#createTrajetModal">Créer un trajet</button>
        <a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>/auth/logout">Déconnexion</a>
    </div>
</nav>

<div class="container mt-5">

    <!-- Tableau unique -->
    <h2 class="h5 mb-3">Tous les trajets</h2>
    <div class="table-responsive mb-5">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Départ</th>
                    <th>Date départ</th>
                    <th>Heure départ</th>
                    <th>Destination</th>
                    <th>Date arrivée</th>
                    <th>Heure arrivée</th>
                    <th>Places restantes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
$all_trajets = [];

foreach ($trajets as $t) {
    $all_trajets[] = ['trajet' => $t, 'owner' => false];
}
foreach ($trajets_user as $t) {
    $all_trajets[] = ['trajet' => $t, 'owner' => true];
}

foreach ($all_trajets as $entry):
    $trajet = $entry['trajet'];
    $isOwner = $entry['owner'];

    $timestampDepart = strtotime($trajet['date_heure_depart']);
    if ($timestampDepart < strtotime(date('Y-m-d'))) {
        continue; // Ignore les trajets passés
    }

    $dateDepart = date('d/m/Y', strtotime($trajet['date_heure_depart']));
    $heureDepart = date('H:i', strtotime($trajet['date_heure_depart']));
    $dateArrivee = date('d/m/Y', strtotime($trajet['date_heure_arrivee']));
    $heureArrivee = date('H:i', strtotime($trajet['date_heure_arrivee']));
?>
    <tr>
        <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
        <td><?= $dateDepart ?></td>
        <td><?= $heureDepart ?></td>
        <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
        <td><?= $dateArrivee ?></td>
        <td><?= $heureArrivee ?></td>
        <td><?= $trajet['places_disponibles'] ?>/<?= $trajet['places_total'] ?></td>
        <td>
            <?php if ($isOwner): ?>
                <button class="btn btn-sm btn-outline-warning" onclick='openEditModal(<?= json_encode($trajet, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>)'>Modifier</button>
                <a href="<?= BASE_URL ?>/trajet/delete/<?= $trajet['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce trajet ?')">Supprimer</a>
            <?php else: ?>
                <button class="btn btn-sm btn-outline-primary" onclick='openReservationModal(<?= json_encode($trajet, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>)'>Réserver</button>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>

        </table>
    </div>

    <h2 class="h5 mb-3">Mes réservations</h2>
    <div class="table-responsive mb-5">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Trajet</th>
                    <th>Places réservées</th>
                    <th>Date départ</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <?php
if (!empty($reservations)) {
    usort($reservations, function($a, $b) {
        return strtotime($a['date_heure_depart']) <=> strtotime($b['date_heure_depart']);
    });
}
?>

<tbody>
<?php if (!empty($reservations)): ?>
    <?php foreach ($reservations as $res): ?>
    <tr>
        <td>
            <?= htmlspecialchars($res['ville_depart']) ?> → <?= htmlspecialchars($res['ville_arrivee']) ?>
        </td>
        <td><?= (int)$res['places'] ?></td>
        <td>
            <?php 
            $timestamp = strtotime($res['date_heure_depart'] ?? '');
            echo $timestamp ? date('d/m/Y', $timestamp) : 'N/A'; 
            ?>
        </td>
        <td>
            <form method="post" action="<?= BASE_URL ?>/reservation/delete" onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                <input type="hidden" name="reservation_id" value="<?= (int)$res['id'] ?>" />
                <button type="submit" class="btn btn-sm btn-danger">Annuler</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="4">Vous n'avez aucune réservation.</td></tr>
<?php endif; ?>
</tbody>

        </table>
    </div>

</div>

<!-- Modal création trajet -->
<div class="modal fade" id="createTrajetModal" tabindex="-1" aria-labelledby="createTrajetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="<?= BASE_URL ?>/trajet/store" class="modal-content" id="createTrajetForm">
      <div class="modal-header">
        <h5 class="modal-title" id="createTrajetModalLabel">Créer un nouveau trajet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="employe_id" value="<?= htmlspecialchars($user['id']) ?>" />

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" for="agence_depart_id">Agence de départ</label>
            <select name="agence_depart_id" id="agence_depart_id" class="form-select" required>
              <?php foreach ($agences as $agence): ?>
                <option value="<?= htmlspecialchars($agence['id']) ?>"><?= htmlspecialchars($agence['nom_ville']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="agence_arrivee_id">Agence d'arrivée</label>
            <select name="agence_arrivee_id" id="agence_arrivee_id" class="form-select" required>
              <?php foreach ($agences as $agence): ?>
                <option value="<?= htmlspecialchars($agence['id']) ?>"><?= htmlspecialchars($agence['nom_ville']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="date_heure_depart">Date et heure de départ</label>
            <input type="datetime-local" name="date_heure_depart" id="date_heure_depart" class="form-control" step="900" required />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="date_heure_arrivee">Date et heure d'arrivée</label>
            <input type="datetime-local" name="date_heure_arrivee" id="date_heure_arrivee" class="form-control" step="900" required />
          </div>

          <div class="col-12">
            <label class="form-label" for="places_total">Nombre de places</label>
            <input type="number" name="places_total" id="places_total" class="form-control" min="1" required />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Créer</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Fonction pour désactiver la même agence dans l'autre select
  function updateAgenceArriveeOptions() {
    const departSelect = document.getElementById('agence_depart_id');
    const arriveeSelect = document.getElementById('agence_arrivee_id');
    const departValue = departSelect.value;

    for (let option of arriveeSelect.options) {
      option.disabled = option.value === departValue;
    }

    // Si l'option actuellement sélectionnée est désactivée, on la change
    if (arriveeSelect.value === departValue) {
      arriveeSelect.value = '';
    }
  }

  document.getElementById('agence_depart_id').addEventListener('change', updateAgenceArriveeOptions);

  // Validation à la soumission du formulaire
  document.getElementById('createTrajetForm').addEventListener('submit', function(event) {
    const depart = document.getElementById('agence_depart_id').value;
    const arrivee = document.getElementById('agence_arrivee_id').value;

    if (depart === arrivee) {
      event.preventDefault();
      alert('L\'agence de départ et l\'agence d\'arrivée doivent être différentes.');
    }
  });

  // Initialiser au chargement de la modal (au cas où)
  document.getElementById('createTrajetModal').addEventListener('show.bs.modal', updateAgenceArriveeOptions);
</script>


<!-- Modal réservation -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="reservationForm" method="post" action="<?= BASE_URL ?>/reservation/store" class="modal-content" onsubmit="return validateReservationForm();">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationModalLabel">Réserver un trajet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p><strong>Proposé par :</strong> <span id="res-propose-par"></span></p>
        <p><strong>Téléphone :</strong> <span id="res-tel"></span></p>
        <p><strong>Email :</strong> <span id="res-email"></span></p>
        <p><strong>Places disponibles :</strong> <span id="res-places"></span></p>

        <input type="hidden" name="trajet_id" id="res-trajet-id" />

        <div class="mb-3">
            <label for="places_reservees" class="form-label">Nombre de places à réserver</label>
            <input type="number" class="form-control" id="places_reservees" name="places_reservees" min="1" value="1" required />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Réserver</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal modification trajet -->
<div class="modal fade" id="editTrajetModal" tabindex="-1" aria-labelledby="editTrajetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="<?= BASE_URL ?>/trajet/update" class="modal-content" id="editTrajetForm">
      <div class="modal-header">
        <h5 class="modal-title" id="editTrajetModalLabel">Modifier un trajet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="trajet_id" id="edit_trajet_id" />

        <div class="row g-3">
          <div class="col-md-6">
            <label for="edit_agence_depart_id" class="form-label">Agence de départ</label>
            <select name="agence_depart_id" id="edit_agence_depart_id" class="form-select" required>
              <?php foreach ($agences as $agence): ?>
                <option value="<?= htmlspecialchars($agence['id']) ?>"><?= htmlspecialchars($agence['nom_ville']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label for="edit_agence_arrivee_id" class="form-label">Agence d'arrivée</label>
            <select name="agence_arrivee_id" id="edit_agence_arrivee_id" class="form-select" required>
              <?php foreach ($agences as $agence): ?>
                <option value="<?= htmlspecialchars($agence['id']) ?>"><?= htmlspecialchars($agence['nom_ville']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label for="edit_date_heure_depart" class="form-label">Date et heure de départ</label>
            <input type="datetime-local" name="date_heure_depart" id="edit_date_heure_depart" class="form-control" step="900" required />
          </div>

          <div class="col-md-6">
            <label for="edit_date_heure_arrivee" class="form-label">Date et heure d'arrivée</label>
            <input type="datetime-local" name="date_heure_arrivee" id="edit_date_heure_arrivee" class="form-control" step="900" required />
          </div>

          <div class="col-12">
            <label for="edit_places_total" class="form-label">Nombre de places</label>
            <input type="number" name="places_total" id="edit_places_total" class="form-control" min="1" required />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
  </div>
</div>



<script>
// Ouverture modal réservation
function openReservationModal(trajet) {
    document.getElementById('res-propose-par').textContent = trajet.employe_prenom + ' ' + trajet.employe_nom;
    document.getElementById('res-tel').textContent = trajet.telephone;
    document.getElementById('res-email').textContent = trajet.email;
    document.getElementById('res-places').textContent = trajet.places_disponibles + ' / ' + trajet.places_total;
    document.getElementById('res-trajet-id').value = trajet.id;

    const placesInput = document.getElementById('places_reservees');
    placesInput.max = trajet.places_disponibles;
    placesInput.value = 1;

    const reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
    reservationModal.show();
}

// Validation JS simple du formulaire réservation
function validateReservationForm() {
    const placesInput = document.getElementById('places_reservees');
    const maxPlaces = parseInt(placesInput.max, 10);
    const requested = parseInt(placesInput.value, 10);

    if (requested > maxPlaces) {
        alert(`Vous ne pouvez pas réserver plus de ${maxPlaces} place(s) disponibles.`);
        placesInput.focus();
        return false;
    }
    if (requested < 1) {
        alert('Veuillez saisir au moins 1 place.');
        placesInput.focus();
        return false;
    }
    return true;
}
</script>
<!-- Modal modification trajet -->
<script>
function openEditModal(trajet) {
    document.getElementById('edit_trajet_id').value = trajet.id;

    // Remplir les selects avec les agences
    document.getElementById('edit_agence_depart_id').value = trajet.agence_depart_id;
    document.getElementById('edit_agence_arrivee_id').value = trajet.agence_arrivee_id;

    // Formater la date pour input datetime-local
    function formatDateTimeLocal(datetimeStr) {
        const dt = new Date(datetimeStr);
        if (isNaN(dt)) return '';
        const year = dt.getFullYear();
        const month = String(dt.getMonth() + 1).padStart(2, '0');
        const day = String(dt.getDate()).padStart(2, '0');
        const hours = String(dt.getHours()).padStart(2, '0');
        const minutes = String(dt.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    document.getElementById('edit_date_heure_depart').value = formatDateTimeLocal(trajet.date_heure_depart);
    document.getElementById('edit_date_heure_arrivee').value = formatDateTimeLocal(trajet.date_heure_arrivee);

    document.getElementById('edit_places_total').value = trajet.places_total;

    updateEditAgenceArriveeOptions();

    const editModal = new bootstrap.Modal(document.getElementById('editTrajetModal'));
    editModal.show();
}

function updateEditAgenceArriveeOptions() {
    const departSelect = document.getElementById('edit_agence_depart_id');
    const arriveeSelect = document.getElementById('edit_agence_arrivee_id');
    const departValue = departSelect.value;

    for (let option of arriveeSelect.options) {
        option.disabled = option.value === departValue;
    }

    if (arriveeSelect.value === departValue) {
        arriveeSelect.value = '';
    }
}

document.getElementById('edit_agence_depart_id').addEventListener('change', updateEditAgenceArriveeOptions);

document.getElementById('editTrajetForm').addEventListener('submit', function(event) {
    const depart = document.getElementById('edit_agence_depart_id').value;
    const arrivee = document.getElementById('edit_agence_arrivee_id').value;

    if (depart === arrivee) {
        event.preventDefault();
        alert('L\'agence de départ et l\'agence d\'arrivée doivent être différentes.');
    }
});
</script>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
