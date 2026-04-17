@php
    $role = auth()->user()?->getRoleName() ?? 'student';
    $shortcutView = "layouts.partials.shortcut_menus.{$role}";
@endphp

@includeIf($shortcutView)
