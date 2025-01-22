<script lang="ts">
  import { PUBLIC_BACKEND_URL } from "$env/static/public";

  import blueLogoUrl from "$lib/assets/images/blue_logo.svg";

  import Button from "$lib/components/Button";
  import Lucide from "$lib/components/Lucide";

  import { navbar_items } from "$lib/constants";

  import { page } from "$app/state";

  function isActive(path: string) {
    return page.url.pathname === path;
  }

  import { goto } from "$app/navigation";
  import { user } from "@/stores/user";

  const { role, image } = user();

  console.log("http://127.0.0.1:8000/storage/" + image);
</script>

<div
  class="flex justify-between items-center bg-white py-5 px-5 md:px-10 lg:px-16 sticky top-0 left-0 z-20"
>
  <a href="/" class="flex items-center">
    <img alt="arniva licence manager" class="w-6" src={blueLogoUrl} />
    <span class="ml-3 text-lg text-blue-800 font-medium">
      Rezervasyon Sistemi
    </span>
  </a>
  {#if role === "normal_user"}
    <div class="flex items-center justify-center gap-5">
      <button
        type="button"
        onclick={() => goto("/profile")}
        class="w-8 h-8 rounded-full overflow-hidden cursor-pointer"
      >
        <img
          src={("http://127.0.0.1:8000/storage/" + image).replace(/\\/g, "/")}
          alt=""
          class="w-full h-full object-cover"
        />
      </button>
      <Button
        onclick={() => {
          goto("/payol");
        }}
        variant="primary"
        type="button">Pay Ol</Button
      >
    </div>
  {/if}
  {#if role && role !== "normal_user"}
    <div class="flex items-center justify-center gap-5">
      <button
        type="button"
        onclick={() => goto("/profile")}
        class="w-8 h-8 rounded-full overflow-hidden cursor-pointer"
      >
        <img
          src={`${PUBLIC_BACKEND_URL}/${image}`}
          alt=""
          class="w-full h-full object-cover"
        />
      </button>
      <Button
        onclick={() => {
          goto("/panel");
        }}
        variant="primary"
        type="button">Panel</Button
      >
    </div>
  {/if}
  {#if !role}
    <Button
      onclick={() => {
        goto("/giris");
      }}
      variant="outline-primary"
      type="button">Giriş Yap</Button
    >
  {/if}
</div>
<div
  class="flex overflow-x-scroll gap-3 px-5 md:px-10 lg:px-16 border-b-2 pb-4"
>
  {#each navbar_items as { icon, path, value }}
    <a
      href={path}
      class={`flex gap-2 items-center rounded-full px-5 py-2 hover:bg-blue-800 hover:text-white transition-all ${isActive(path) ? "text-blue-800 border-blue-800 border-2" : ""}`}
    >
      <Lucide {icon} className="w-6 h-6" />
      <p class="text-xl">{value}</p>
    </a>
  {/each}
</div>
