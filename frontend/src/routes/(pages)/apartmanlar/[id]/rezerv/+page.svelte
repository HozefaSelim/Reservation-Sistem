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
  onDestroy(() => {
    stopSlideshow();
  });
</script>

<div
  class="grid md:grid-cols-4 gap-5 px-5 md:px-10 lg:px-16 my-5 md:divide-x divide-blue-800"
>
  <div class="md:col-span-1">
    <div class="flex flex-col flex-1 gap-3">
      <div class="flex justify-between items-start">
        <div>
          <h4 class="text-blue-800 font-semibold text-3xl">
            Collesium Garden <span class="text-orange-400 text-lg"
              >(1999.99 TL)</span
            >
          </h4>
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
      <p class="text-lg text-slate-700 mb-3">
        Merkeze yakın, doğayla iç içe Collesium Garden, sizi huzurlu bir masalın
        içinde kaybolmaya davet ediyor.
      </p>
      <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
        <Lucide icon="Users" className="text-blue-800" />
        <p class="font-semibold">Kapasite: 5</p>
      </span>
    </div>
  </div>
  <div class="md:col-span-3 h-fit md:pl-4">
    <h3 class="text-lg md:text-2xl font-semibold mb-3 text-center">
      Rezervasyon ve Ödeme Bilgileri Giriniz
    </h3>
    <form class="text-center">
      <div class="grid lg:grid-cols-2 gap-3">
        <Input placeholder="Başlangıç tarih" name="start_date" />
        <Input placeholder="Bitiş tarih" name="end_date" />
        <Input placeholder="Kartaki İsim" name="card_name" />
        <Input placeholder="Kart Numarası" name="card_number" />
        <Input placeholder="Kart Son Tarih" name="card_due_date" />
        <Input placeholder="CVV kodu" name="cvv" />
      </div>
      <Button variant="primary" type="button" className="mx-auto my-5"
        >Rezervasyon yap</Button
      >
    </form>
  </div>
</div>
