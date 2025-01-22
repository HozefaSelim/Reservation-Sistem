<script lang="ts">
  import "../../assets/css/themes/rubick/side-nav.css";
  import logoUrl from "$lib/assets/images/logo.svg";

  import MobileMenu from "$lib/components/MobileMenu";
  import TopBar from "./TopBar.svelte";
  import Lucide from "$lib/components/Lucide";
  import { menuStore, menu } from "@/stores/menu";
  import { page } from "$app/stores";
  import { type FormattedMenu, linkTo, nestedMenu } from "./side-menu";
  import Tippy from "$lib/components/Tippy";
  import { slide } from "svelte/transition";
  import { onMount } from "svelte";
  import clsx from "clsx";

  let formattedMenu: Array<FormattedMenu | "divider"> = [];
  const sideMenu = () => nestedMenu(menu(), $page.url);

  $: {
    if ($menuStore || $page) {
      formattedMenu = sideMenu();
    }
  }

  let windowWidth: number;
  onMount(() => {
    windowWidth = window.innerWidth;
    window.addEventListener("resize", () => {
      windowWidth = window.innerWidth;
    });
  });
</script>

<div
  class={clsx([
    "rubick px-5 sm:px-8 py-5",
    "before:content-[''] before:bg-gradient-to-b before:from-theme-1 before:to-theme-2 dark:before:from-darkmode-800 dark:before:to-darkmode-800 before:fixed before:inset-0 before:z-[-1]",
  ])}
>
  <MobileMenu />
  <div class="flex mt-[4.7rem] md:mt-0">
    <!-- BEGIN: Side Menu -->
    <nav
      class="side-nav hidden w-[80px] overflow-x-hidden pb-16 pr-5 md:block xl:w-[230px]"
    >
      <a href="/panel" class="flex items-center pt-4 pl-5 intro-x">
        <img
          alt="Midone Tailwind HTML Admin Template"
          class="w-6"
          src={logoUrl}
        />
        <span class="hidden ml-2 text-lg text-white xl:block text-nowrap">
          Reservasyon Paneli
        </span>
      </a>
      <div class="my-6 side-nav__divider"></div>
      <ul>
        {#each formattedMenu as menu}
          {#if menu == "divider"}
            <li class="my-6 side-nav__divider"></li>
          {:else}
            <li>
              <Tippy
                as="a"
                content={menu.title}
                options={{
                  placement: "right",
                }}
                disable={windowWidth > 1260}
                href={menu.subMenu ? menu.subMenu[0].pathname : menu.pathname}
                on:click={(e) => {
                  e.preventDefault();
                  linkTo(menu);
                  formattedMenu = [...formattedMenu];
                }}
                class={clsx([
                  menu.active ? "side-menu side-menu--active" : "side-menu",
                ])}
              >
                <div class="side-menu__icon">
                  <Lucide icon={menu.icon} />
                </div>
                <div class="side-menu__title">
                  {menu.title}
                  {#if menu.subMenu}
                    <div
                      class={clsx([
                        "side-menu__sub-icon",
                        { "transform rotate-180": menu.activeDropdown },
                      ])}
                    >
                      <Lucide icon="ChevronDown" />
                    </div>
                  {/if}
                </div>
              </Tippy>
              {#if menu.subMenu && menu.activeDropdown}
                <ul
                  class={clsx([menu.activeDropdown && "side-menu__sub-open"])}
                  transition:slide|local={{ duration: 300 }}
                >
                  {#each menu.subMenu as subMenu}
                    <li>
                      <Tippy
                        as="a"
                        content={subMenu.title}
                        options={{
                          placement: "right",
                        }}
                        disable={windowWidth > 1260}
                        href={subMenu.subMenu ? "#" : subMenu.pathname}
                        class={clsx([
                          subMenu.active
                            ? "side-menu side-menu--active"
                            : "side-menu",
                        ])}
                        on:click={(e) => {
                          e.preventDefault();
                          linkTo(subMenu);
                          formattedMenu = [...formattedMenu];
                        }}
                      >
                        <div class="side-menu__icon">
                          <Lucide icon={subMenu.icon} />
                        </div>
                        <div class="side-menu__title">
                          {subMenu.title}
                          {#if subMenu.subMenu}
                            <div
                              class={clsx([
                                "side-menu__sub-icon",
                                subMenu.activeDropdown &&
                                  "transform rotate-180",
                              ])}
                            >
                              <Lucide icon="ChevronDown" />
                            </div>
                          {/if}
                        </div>
                      </Tippy>
                      {#if subMenu.subMenu && subMenu.activeDropdown}
                        <ul
                          class={clsx([
                            subMenu.activeDropdown && "side-menu__sub-open",
                          ])}
                          transition:slide|local={{ duration: 300 }}
                        >
                          {#each subMenu.subMenu as lastSubMenu, lastSubMenuKey}
                            <li>
                              <Tippy
                                as="a"
                                content={lastSubMenu.title}
                                options={{
                                  placement: "right",
                                }}
                                disable={windowWidth > 1260}
                                href={lastSubMenu.subMenu
                                  ? "#"
                                  : lastSubMenu.pathname}
                                class={clsx([
                                  lastSubMenu.active
                                    ? "side-menu side-menu--active"
                                    : "side-menu",
                                ])}
                                on:click={(e) => {
                                  e.preventDefault();
                                  linkTo(lastSubMenu);
                                  formattedMenu = [...formattedMenu];
                                }}
                              >
                                <div class="side-menu__icon">
                                  <Lucide icon={lastSubMenu.icon} />
                                </div>
                                <div class="side-menu__title">
                                  {lastSubMenu.title}
                                  {#if lastSubMenu.subMenu}
                                    <div
                                      class={clsx([
                                        "side-menu__sub-icon",
                                        lastSubMenu.activeDropdown &&
                                          "transform rotate-180",
                                      ])}
                                    >
                                      <Lucide icon="ChevronDown" />
                                    </div>
                                  {/if}
                                </div>
                              </Tippy>
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
      </ul>
    </nav>
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div
      class="md:max-w-auto min-h-screen min-w-0 max-w-full flex-1 rounded-[30px] bg-slate-100 px-4 pb-10 before:block before:h-px before:w-full before:content-[''] dark:bg-darkmode-700 md:px-[22px]"
    >
      <TopBar />
      <slot />
    </div>
    <!-- END: Content -->
  </div>
</div>
