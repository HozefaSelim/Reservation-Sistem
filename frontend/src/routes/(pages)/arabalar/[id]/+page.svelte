<script lang="ts">
  import { fade } from "svelte/transition";

  import Lucide from "$lib/components/Lucide";

  import { formatDate } from "$lib/functions";

  import Image1 from "$lib/assets/images/langing/1.jpg";
  import Image2 from "$lib/assets/images/langing/2.jpg";
  import Image3 from "$lib/assets/images/langing/3.jpg";
  import Image4 from "$lib/assets/images/langing/4.jpg";
  import Image5 from "$lib/assets/images/langing/5.jpg";

  const images = [Image1, Image2, Image3, Image4, Image5];
  let index = 0;
  let interval: NodeJS.Timeout;

  // Automatically update index at regular intervals
  function startSlideshow() {
    interval = setInterval(() => {
      index = (index + 1) % images.length; // Loop back to 0 after the last image
    }, 10000); // Change every 10 seconds
  }

  function stopSlideshow() {
    clearInterval(interval);
  }

  // Start the slideshow on component mount
  startSlideshow();

  // Clear the interval on component destroy
  import { onDestroy } from "svelte";
  import Button from "@/lib/components/Button";
  import { Input } from "@/lib/components/Input";
  import { goto } from "$app/navigation";
  onDestroy(() => {
    stopSlideshow();
  });
</script>

<div class="grid md:grid-cols-4 gap-5 px-5 md:px-10 lg:px-16 my-5">
  <div class="hidden md:block md:col-span-1">
    <ul class="h-fit w-full border rounded-3xl p-5 flex flex-col gap-2">
      <h3 class="text-3xl font-bold text-slate-800 my-5 border-b-2">
        Yorumlar
      </h3>
      <li class="bg-blue-100/50 p-3 rounded-2xl">
        <div class="flex gap-2">
          <span
            class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-lg"
            >3.5</span
          >
          <div>
            <h5 class="text-blue-800 text-base font-medium">Hussein</h5>
            <p class="text-slate-500 text-xs">{formatDate(new Date(), "1")}</p>
          </div>
        </div>
        <p class="text-sm mt-3 font-medium text-slate-700">Çok kötü bir otel</p>
      </li>
      <a
        href="/oteller/djksadl#yorumlar"
        class="underline text-end text-sm text-blue-800"
      >
        Tümü
      </a>
    </ul>
  </div>
  <div class="md:col-span-3 divide-y divide-blue-800">
    <div class="flex flex-col flex-1 gap-3">
      <div class="flex justify-between items-start">
        <div>
          <h4 class="text-blue-800 font-semibold text-3xl">Collesium Garden</h4>
          <p class="flex items-center gap-2 text-slate-600">
            <Lucide icon="MapPinCheckInside" /> Konyaaltı Merkez, Konyaaltı
          </p>
        </div>
        <span
          class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-xl"
          >3.5</span
        >
      </div>
    </div>
    <div class="h-fit w-full border rounded-3xl p-5 mt-4 cursor-pointer">
      <div class="h-80 overflow-hidden rounded-2xl mb-3">
        {#each images as image, i (i)}
          {#if i === index}
            <img
              src={image}
              alt="otel"
              class="object-cover w-full h-full"
              transition:fade={{ duration: 400 }}
            />
          {/if}
        {/each}
      </div>
      <ul class="flex gap-2 flex-wrap mb-3">
        {#each images as image, i}
          <button
            onclick={() => (index = i)}
            class="h-20 w-20 overflow-hidden rounded-2xl"
          >
            <img src={image} alt="otel" class="object-cover w-full h-full" />
          </button>
        {/each}
      </ul>
      <p class="text-lg text-slate-700 mb-3">
        Merkeze yakın, doğayla iç içe Collesium Garden, sizi huzurlu bir masalın
        içinde kaybolmaya davet ediyor.
      </p>
      <div class="flex justify-between items-center">
        <div class="flex flex-warp gap-2">
          <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
            <Lucide icon="Car" className="text-blue-800" />
            <p class="font-semibold">Model: 5</p>
          </span>
          <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
            <Lucide icon="CalendarHeart" className="text-blue-800" />
            <p class="font-semibold">Marka: 5</p>
          </span>
          <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
            <Lucide icon="Hash" className="text-blue-800" />
            <p class="font-semibold">plaka: MD 34 4234</p>
          </span>
        </div>
        <Button
          onclick={() => goto("/arabalar/djksadl/rezerv")}
          variant="primary"
          type="button"
          className="w-fit">Rezerv Et</Button
        >
      </div>
    </div>
    <ul class="h-fit w-full border rounded-3xl p-5 mt-5 flex flex-col gap-2">
      <h3 class="text-3xl font-bold text-slate-800 my-5 border-b-2">
        Yorumlar
      </h3>
      <li class="bg-blue-100/50 p-3 rounded-2xl">
        <div class="flex gap-2">
          <span
            class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-lg"
            >3.5</span
          >
          <div>
            <h5 class="text-blue-800 text-base font-medium">Hussein</h5>
            <p class="text-slate-500 text-xs">{formatDate(new Date(), "1")}</p>
          </div>
        </div>
        <p class="text-sm mt-3 font-medium text-slate-700">Çok kötü bir otel</p>
      </li>
      <li class="bg-blue-100/50 p-3 rounded-2xl">
        <div class="flex gap-2">
          <span
            class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-lg"
            >3.5</span
          >
          <div>
            <h5 class="text-blue-800 text-base font-medium">Hussein</h5>
            <p class="text-slate-500 text-xs">{formatDate(new Date(), "1")}</p>
          </div>
        </div>
        <p class="text-sm mt-3 font-medium text-slate-700">Çok kötü bir otel</p>
      </li>
      <li class="bg-blue-100/50 p-3 rounded-2xl">
        <div class="flex gap-2">
          <span
            class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-lg"
            >3.5</span
          >
          <div>
            <h5 class="text-blue-800 text-base font-medium">Hussein</h5>
            <p class="text-slate-500 text-xs">{formatDate(new Date(), "1")}</p>
          </div>
        </div>
        <p class="text-sm mt-3 font-medium text-slate-700">Çok kötü bir otel</p>
      </li>
      <li class="bg-blue-100/50 p-3 rounded-2xl">
        <div class="flex gap-2">
          <span
            class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-lg"
            >3.5</span
          >
          <div>
            <h5 class="text-blue-800 text-base font-medium">Hussein</h5>
            <p class="text-slate-500 text-xs">{formatDate(new Date(), "1")}</p>
          </div>
        </div>
        <p class="text-sm mt-3 font-medium text-slate-700">Çok kötü bir otel</p>
      </li>
    </ul>
  </div>
</div>
