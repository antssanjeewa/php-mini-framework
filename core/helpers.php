<?php

if (!function_exists('view')) {
  /**
   * View ෆයිල් එකක් Render කිරීම සහ දත්ත පාස් කිරීම.
   */
  function view(string $viewName, array $data = [])
  {
    // 1. Array එකේ තියෙන Keys ටික සාමාන්‍ය Variables බවට පත් කිරීම
    // උදා: ['username' => 'Amila'] එක $username = 'Amila'; බවට පත් වේ.
    extract($data);

    // 1. අදාළ View එකේ HTML කෝඩ් එක මතකයට (Buffer) ලබා ගැනීම
    ob_start();
    $viewFile = __DIR__ . "/../views/{$viewName}.view.php";

    if (file_exists($viewFile)) {
      require $viewFile;
    } else {
      // සොයාගත නොහැකි නම් 404 View එක ලෝඩ් කරයි
      require __DIR__ . "/../views/errors/404.view.php";
    }
    $viewContent = ob_get_clean(); // HTML කෝඩ් එක String එකක් ලෙස $viewContent එකට ගනී

    // 2. ප්‍රධාන Layout එක ලෝඩ් කර, එහි ඇති {{content}} වෙනුවට අපේ View එක ආදේශ කිරීම
    ob_start();
    require __DIR__ . "/../views/layouts/main.view.php";
    $layoutContent = ob_get_clean();

    // {{content}} වෙනුවට සැබෑ පිටුවේ HTML එක දමා Output කිරීම
    return str_replace('{{content}}', $viewContent, $layoutContent);
  }
}