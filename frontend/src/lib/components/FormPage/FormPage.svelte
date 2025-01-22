<script lang="ts">
  import logoUrl from "$lib/assets/images/logo.svg";
  import illustrationUrl from "$lib/assets/images/illustration.svg";

  import clsx from "clsx";

  const { children, text1, text2, text3 } = $props();
</script>

<div
  class={clsx([
    "p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-blue-800 xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600",
    "before:hidden before:xl:block before:content-[''] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-blue-800/20 before:rounded-[100%] before:dark:bg-darkmode-400",
    "after:hidden after:xl:block after:content-[''] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform after:rotate-[-4.5deg] after:bg-blue-800 after:rounded-[100%] after:dark:bg-darkmode-700",
    "block grid-cols-2 gap-4 xl:grid sm:px-10",
  ])}
>
  <!-- BEGIN: Login Info -->
  <div class="relative z-10 flex-col hidden min-h-screen xl:flex">
    <a href="/" class="flex items-center pt-5">
      <img alt="arniva licence manager" class="w-6" src={logoUrl} />
      <span class="ml-3 text-lg text-white"> Rezervasyon Sistemi </span>
    </a>
    <div class="my-auto">
      <img
        alt="rezervasyon yönetim sistemi"
        class="w-1/2 -mt-16"
        src={illustrationUrl}
      />
      <div class="mt-10 text-4xl font-medium leading-tight text-white">
        {text1} <br />
        {text2}
      </div>
      <div class="mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">
        {text3}
      </div>
    </div>
  </div>
  <div class="flex h-screen py-5 my-10 xl:h-auto xl:py-0 xl:my-0">
    {@render children()}
  </div>
</div>
