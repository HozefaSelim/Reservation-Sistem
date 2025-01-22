<!-- <script lang="ts">
  import Button from "$lib/components/Button";
  import Lucide from "$lib/components/Lucide";
  import { areas } from "$lib/constants";
  import { Input } from "$lib/components/Input";

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
  onDestroy(() => {
    stopSlideshow();
  });
</script> -->

<!-- <div
  style={`background-image:url(${images[index]});`}
  class="w-full h-[34.8rem] bg-cover bg-no-repeat bg-center relative flex justify-center flex-col gap-3 px-5 md:px-10 lg:px-16 text-white transition-all"
>
  <h2 class="relative z-10 text-2xl md:text-5xl font-bold">
    Erken Rezervasyon Fırsatları Devam Ediyor!<br /> Son Gün 23 Aralık
  </h2>
  <p class="relative z-10 text-xl md:text-2xl">
    %50'ye varan indirimlere ilave <span
      class="font-bold bg-blue-800 py-1 px-4 rounded-3xl">cashback</span
    > Hediye!
  </p>
  <form
    method="post"
    action="?/search"
    class="relative z-10 mt-5 flex items-center flex-col gap-2 md:gap-0 md:flex-row"
  >
    <div class="relative flex-1 w-full">
      <Input
        placeholder="Nereye Gidiyorsun"
        className="font-medium pl-10 md:rounded-e-none"
        type="text"
        name="address"
      />
      <Lucide
        icon="BedSingle"
        className="absolute top-2 left-3 text-gray-500"
      />
    </div>
    <div class="relative flex-1 w-full">
      <div class="flex w-full">
        <Input
          placeholder="Giriş Tarihi"
          className="font-medium pl-10 border-e-0 md:rounded-s-none md:rounded-e-none"
          type="text"
          name="start_date"
        />
        <Input
          placeholder="Çıkış Tarihi"
          className="font-medium pl-10 border-s-0 md:rounded-s-none md:rounded-e-none"
          type="text"
          name="end_date"
        />
      </div>
      <Lucide
        icon="CalendarDays"
        className="absolute top-2 left-3 text-gray-500"
      />
    </div>
    <div class="relative flex-1 w-full">
      <Input
        placeholder="Kaç kişisiniz ?"
        className="font-medium pl-10 md:rounded-s-none md:rounded-e-none"
        type="text"
        name="Capasite"
      />
      <Lucide icon="User" className="absolute top-2 left-3 text-gray-500" />
    </div>
    <Button
      type="submit"
      variant="primary"
      className="md:rounded-s-none h-10 w-full md:w-32">Ara</Button
    >
  </form>
  <div
    class="bg-gradient-to-t from-blue-800/40 absolute top-0 left-0 w-full h-full"
  />
</div>
<div
  class="my-10 grid lg:grid-cols-6 gap-3 md:gap-5 px-5 md:px-10 lg:px-16 overflow-hidden"
>
  {#each areas as { count, image, title, href }, index}
    <a
      {href}
      style={`background-image:url(${image});`}
      class={`overflow-hidden bg-cover bg-no-repeat bg-center relative text-white p-5 ${index === 0 || index === 1 ? "lg:col-span-3" : "lg:col-span-2"} rounded-2xl h-96 hover:scale-background cursor-pointer`}
    >
      <h3 class="text-3xl font-bold">{title}</h3>
      <p class="text-xl">{count} Tesis</p>
    </a>
  {/each}
</div> -->
