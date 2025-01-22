<script lang="ts">
  import { fade } from "svelte/transition";

  import Lucide from "$lib/components/Lucide";

  import Image1 from "$lib/assets/images/langing/1.jpg";
  import Image2 from "$lib/assets/images/langing/2.jpg";
  import Image3 from "$lib/assets/images/langing/3.jpg";
  import Image4 from "$lib/assets/images/langing/4.jpg";
  import Image5 from "$lib/assets/images/langing/5.jpg";

  export let data;

  const { name, price, discounted_price, hotel, rating, desciption, capacity } =
    data.room;

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
  import DateInput from "@/lib/components/Input/DateInput.svelte";
  import { formHandler } from "@/lib/functions/general.js";
  import { enhance } from "$app/forms";
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
          <h4 class="text-blue-800 font-semibold text-3xl lg:flex gap-2">
            {name}
            <span class="flex gap-2 text-orange-400 text-lg">
              {#if discounted_price && discounted_price > 0}
                <p class="text-gray-600 line-through">{price}</p>
                ({discounted_price})
              {:else}
                ({price})
              {/if}
            </span>
          </h4>
          <p class="flex items-center gap-2 text-slate-600">
            <Lucide icon="MapPinCheckInside" />
            {hotel.location}
          </p>
        </div>
        <span
          class="w-10 h-10 flex items-center justify-center bg-blue-800 rounded-lg text-white font-semibold text-xl"
          >{rating}</span
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
        {desciption}
      </p>
      <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
        <Lucide icon="Users" className="text-blue-800" />
        <p class="font-semibold">{capacity} kişilik</p>
      </span>
    </div>
  </div>
  <div class="md:col-span-3 h-fit md:pl-4">
    <h3 class="text-lg md:text-2xl font-semibold mb-3 text-center">
      Rezervasyon Bilgileri Giriniz
    </h3>
    <form
      action="?/createRes"
      use:enhance={() =>
        async ({ result }) =>
          formHandler(result)}
      method="post"
      class="text-center"
    >
      <div class="grid lg:grid-cols-2 gap-3">
        <DateInput placeholder="Giriş tarih" name="start_date" />
        <DateInput placeholder="Çıkış tarih" name="end_date" />
      </div>
      <Button variant="primary" type="submit" className="mx-auto my-5"
        >Rezervasyon yap</Button
      >
    </form>
  </div>
</div>
