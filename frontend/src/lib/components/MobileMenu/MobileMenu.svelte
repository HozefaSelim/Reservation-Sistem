<script lang="ts">
  import "../../assets/css/vendors/simplebar.css";
  import "$lib/assets/css/components/mobile-menu.css";
  import { type FormattedMenu, nestedMenu } from "./mobile-menu";
  import { linkTo } from "./mobile-menu";
  import { page } from "$app/stores";
  import { menuStore, menu } from "@/stores/menu";
  import Lucide from "$lib/components/Lucide";
  import logoUrl from "$lib/assets/images/logo.svg";
  import clsx from "clsx";
  import SimpleBar from "simplebar";
  import { slide } from "svelte/transition";

  let formattedMenu: Array<FormattedMenu | "divider"> = [];
  const mobileMenu = () => nestedMenu(menu(), $page.url);

  let activeMobileMenu = false;
  let scrollableRef: HTMLDivElement;

  $: {
    if (scrollableRef) {
      new SimpleBar(scrollableRef);
    }

    if ($menuStore || $page) {
      formattedMenu = mobileMenu();
    }
  }
</script>

<!-- BEGIN: Mobile Menu -->
<div
  class={clsx([
    "mobile-menu group top-0 inset-x-0 fixed bg-theme-1/90 z-[60] border-b border-white/[0.08] dark:bg-darkmode-800/90 md:hidden",
    "before:content-[''] before:w-full before:h-screen before:z-10 before:fixed before:inset-x-0 before:bg-black/90 before:transition-opacity before:duration-200 before:ease-in-out",
    "before:invisible before:opacity-0",
    "[&.mobile-menu--active]:before:visible [&.mobile-menu--active]:before:opacity-100",
    activeMobileMenu && "mobile-menu--active",
  ])}
>
  <div class="h-[70px] px-3 sm:px-8 flex items-center">
    <a href="/panel" class="flex mr-auto">
      <img
        alt="Midone Tailwind HTML Admin Template"
        class="w-6"
        src={logoUrl}
      />
    </a>
    <a
      href="#top"
      on:click={(e) => {
        e.preventDefault();
        activeMobileMenu = !activeMobileMenu;
      }}
    >
      <Lucide icon="Kanban" class="w-8 h-8 text-white transform -rotate-90" />
    </a>
  </div>
  <div
    bind:this={scrollableRef}
    class={clsx([
      "h-screen z-20 top-0 left-0 w-[270px] -ml-[100%] bg-primary transition-all duration-300 ease-in-out dark:bg-darkmode-800",
      "[&[data-simplebar]]:fixed [&_.simplebar-scrollbar]:before:bg-black/50",
      "group-[.mobile-menu--active]:ml-0",
    ])}
  >
    <a
      href="#top"
      on:click={(e) => {
        e.preventDefault();
        activeMobileMenu = !activeMobileMenu;
      }}
      class={clsx([
        "fixed top-0 right-0 mt-4 mr-4 transition-opacity duration-200 ease-in-out",
        "invisible opacity-0",
        "group-[.mobile-menu--active]:visible group-[.mobile-menu--active]:opacity-100",
      ])}
    >
      <Lucide icon="CircleX" class="w-8 h-8 text-white transform -rotate-90" />
    </a>
    <ul class="py-2">
      <!-- BEGIN: First Child -->
      {#each formattedMenu as menu}
        {#if menu == "divider"}
          <li class="my-6 menu__divider"></li>
        {:else}
          <li>
            <a
              href={menu.subMenu ? menu.subMenu[0].pathname : menu.pathname}
              on:click={(e) => {
                e.preventDefault();
                linkTo(menu);
                formattedMenu = [...formattedMenu];
              }}
              class={clsx([menu.active ? "menu menu--active" : "menu"])}
            >
              <div class="menu__icon">
                <Lucide icon={menu.icon} />
              </div>
              <div class="menu__title">
                {menu.title}
                {#if menu.subMenu}
                  <div
                    class={clsx([
                      "menu__sub-icon",
                      { "transform rotate-180": menu.activeDropdown },
                    ])}
                  >
                    <Lucide icon="ChevronDown" />
                  </div>
                {/if}
              </div>
            </a>
            {#if menu.subMenu && menu.activeDropdown}
              <ul
                class={clsx([menu.activeDropdown && "menu__sub-open"])}
                transition:slide|local={{ duration: 300 }}
              >
                {#each menu.subMenu as subMenu}
                  <li>
                    <a
                      href={subMenu.subMenu ? "#" : subMenu.pathname}
                      class={clsx([
                        subMenu.active ? "menu menu--active" : "menu",
                      ])}
                      on:click={(e) => {
                        e.preventDefault();
                        linkTo(subMenu);
                        formattedMenu = [...formattedMenu];
                      }}
                    >
                      <div class="menu__icon">
                        <Lucide icon={subMenu.icon} />
                      </div>
                      <div class="menu__title">
                        {subMenu.title}
                        {#if subMenu.subMenu}
                          <div
                            class={clsx([
                              "menu__sub-icon",
                              subMenu.activeDropdown && "transform rotate-180",
                            ])}
                          >
                            <Lucide icon="ChevronDown" />
                          </div>
                        {/if}
                      </div>
                    </a>
                    {#if subMenu.subMenu && subMenu.activeDropdown}
                      <ul
                        class={clsx([
                          subMenu.activeDropdown && "menu__sub-open",
                        ])}
                        transition:slide|local={{ duration: 300 }}
                      >
                        {#each subMenu.subMenu as lastSubMenu}
                          <li>
                            <a
                              href={lastSubMenu.subMenu
                                ? "#"
                                : lastSubMenu.pathname}
                              class={clsx([
                                lastSubMenu.active
                                  ? "menu menu--active"
                                  : "menu",
                              ])}
                              on:click={(e) => {
                                e.preventDefault();
                                linkTo(lastSubMenu);
                                formattedMenu = [...formattedMenu];
                              }}
                            >
                              <div class="menu__icon">
                                <Lucide icon={lastSubMenu.icon} />
                              </div>
                              <div class="menu__title">
                                {lastSubMenu.title}
                                {#if lastSubMenu.subMenu}
                                  <div
                                    class={clsx([
                                      "menu__sub-icon",
                                      lastSubMenu.activeDropdown &&
                                        "transform rotate-180",
                                    ])}
                                  >
                                    <Lucide icon="ChevronDown" />
                                  </div>
                                {/if}
                              </div>
                            </a>
                          </li>
                        {/each}
                      </ul>
                    {/if}
                  </li>
                {/each}
              </ul>
            {/if}
          </li>
        {/if}
      {/each}
      <!-- END: First Child -->
    </ul>
  </div>
</div>
<!-- END: Mobile Menu -->
