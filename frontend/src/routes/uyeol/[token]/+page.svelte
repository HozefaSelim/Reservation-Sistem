<script lang="ts">
  import { goto } from "$app/navigation";

  import success from "$lib/assets/animations/email-not-verified.json";
  import error from "$lib/assets/animations/email-verified.json";

  import { addToast } from "$lib/functions";

  import Animation from "$lib/components/Animation";

  import type { PageData } from "./$types";

  let { data }: { data: PageData } = $props();

  const { title, message, status } = data;
  const condition = status === 200;

  $effect(() => {
    addToast(title, message, condition ? "success" : "error");
    if (condition) {
      setTimeout(() => goto("/giris"), 5000);
    }
  });
</script>

<div
  class="flex flex-col items-center justify-center gap-8 min-h-screen text-center"
>
  <Animation animationData={condition ? error : success} />
  <h2 class="text-2xl sm:text-3xl font-semibold">
    {#if condition}
      Hesabınız başarıyla oluşturuldu
    {:else}
      Hesabınız oluşturulmamış
    {/if}
  </h2>
</div>
