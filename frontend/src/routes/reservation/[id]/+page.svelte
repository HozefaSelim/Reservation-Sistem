<script>
  import { formatDate } from "$lib/functions";

  import Image from "$lib/assets/images/langing/2.jpg";
  import { fly } from "svelte/transition";
  import Lucide from "@/lib/components/Lucide";

  export let data;

  const reservation = data.res;
</script>

<h2 class="mt-10 text-lg font-medium px-16">Rezervasyonlar Listesi</h2>
<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-5 px-16">
  <!-- BEGIN: Users Layout -->
  <!-- {#each packages as { active, id, photo_url, name, _count }} -->
  {#each reservation as { start_data, end_date }}
    <div transition:fly={{ x: 200 }} class="box intro-y">
      <div class="p-5">
        <div
          class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
        >
          <img alt="" class="rounded-md" src={Image} />
        </div>
        <div class="mt-5 text-slate-600 dark:text-slate-500">
          <div class="flex items-center mt-2">
            <Lucide icon="CalendarArrowDown" className="w-4 h-4 mr-2" />
            Giriş Tarih: {formatDate(start_data)}
          </div>
          <div class="flex items-center mt-2">
            <Lucide icon="CalendarArrowUp" className="w-4 h-4 mr-2" />
            Çıkış Tarih: {formatDate(end_date)}
          </div>
        </div>
      </div>
    </div>
  {/each}
  <!-- {/each} -->
</div>
