<h1>User Profile Page</h1>
<p>දැනට පරීක්ෂා කරන පරිශීලකයාගේ අංකය (User ID) වන්නේ: <strong> <?php echo $user['id'] ?? '-'; ?></strong></p>

<?php if (isset($users)): ?>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
    </tr>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td>
          <a href="/user/<?= $user['id'] ?>">Edit</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<h1>Add New User 📦</h1>

<form action="/user/save"
  method="POST"
  style="max-width: 400px;">

  <?php echo csrf_field(); ?>
  <input hidden
    name="id"
    value="<?php echo $user['id'] ?? ''; ?>" />

  <div style="margin-bottom: 15px;">
    <label for="name"
      style="display: block; margin-bottom: 5px;">User Name:</label>
    <input type="text"
      id="name"
      name="name"
      value="<?php echo $user['name'] ?? ''; ?>"
      required
      style="width: 100%; padding: 8px;">
  </div>
  <span class="text-danger"
    style="color: red;"><?= errors('name') ?></span>

  <div style="margin-bottom: 15px;">
    <label for="email"
      style="display: block; margin-bottom: 5px;">Email:</label>
    <input type="text"
      id="email"
      name="email"
      value="<?php echo $user['email'] ?? ''; ?>"
      required
      style="width: 100%; padding: 8px;">
  </div>
  <span class="text-danger"
    style="color: red;">
    <?= errors('email') ?>
  </span>

  <button type="submit"
    style="background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 3px; cursor: pointer;">
    Save User
  </button>
</form>