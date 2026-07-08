<h1>User Profile Page</h1>
<p>දැනට පරීක්ෂා කරන පරිශීලකයාගේ අංකය (User ID) වන්නේ: <strong> <?php echo $id ?? '-'; ?></strong></p>

<h1>Add New User 📦</h1>

<form action="/user/save"
  method="POST"
  style="max-width: 400px;">

  <?php echo csrf_field(); ?>

  <div style="margin-bottom: 15px;">
    <label for="name"
      style="display: block; margin-bottom: 5px;">User Name:</label>
    <input type="text"
      id="name"
      name="name"
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