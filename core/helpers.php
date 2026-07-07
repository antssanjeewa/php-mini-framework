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

    // 2. View ෆයිල් එක තියෙන පාර (Path) සකස් කිරීම
    $viewFile = __DIR__ . "/../views/{$viewName}.view.php";

    if (!file_exists($viewFile)) {
      throw new Exception("View Error: '{$viewName}' කියන View ෆයිල් එක සොයාගත නොහැක!");
    }

    // 3. HTML කෝඩ් එක output එකක් විදිහට පෙන්වීමට require කිරීම
    require $viewFile;
  }
}