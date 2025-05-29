<!-- app/Views/admin/edit.php -->

<h2>Modifier l'utilisateur</h2>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Prénom</label>
    <input type="text" name="prenom" value="<?php echo isset($utilisateur['prenom']) ? $utilisateur['prenom'] : ''; ?>" required>

    <label>Nom</label>
    <input type="text" name="nom" value="<?php echo isset($utilisateur['nom']) ? $utilisateur['nom'] : ''; ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?php echo isset($utilisateur['email']) ? $utilisateur['email'] : ''; ?>" required>

    <label>Téléphone</label>
    <input type="text" name="telephone" value="<?php echo isset($utilisateur['telephone']) ? $utilisateur['telephone'] : ''; ?>" required>

    <label>Rôle</label>
    <select name="role">
        <option value="utilisateur" <?php echo ($utilisateur['role'] === 'utilisateur') ? 'selected' : ''; ?>>Utilisateur</option>
        <option value="admin" <?php echo ($utilisateur['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
    </select>

    <label>Mot de passe (optionnel)</label>
    <input type="password" name="password">

    <button type="submit">Modifier</button>
</form>
