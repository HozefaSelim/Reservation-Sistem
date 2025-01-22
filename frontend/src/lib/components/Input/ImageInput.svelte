<script lang="ts">
  import Lucide from "$lib/components/Lucide";

  let { previewImage = null } = $props();

  const handleImageChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        previewImage = reader.result as string;
      };
      reader.readAsDataURL(file);
    }
  };

  const handleDrop = (event: DragEvent) => {
    event.preventDefault();
    const file = event.dataTransfer?.files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        previewImage = reader.result as string;
      };
      reader.readAsDataURL(file);
    }
  };

  const preventDefaults = (event: DragEvent) => {
    event.preventDefault();
    event.stopPropagation();
  };
</script>

<!-- svelte-ignore a11y_no_static_element_interactions -->
<div
  class="w-full lg:w-[350px] h-40 bg-white rounded-lg"
  ondrop={handleDrop}
  ondragover={preventDefaults}
  ondragenter={preventDefaults}
  ondragleave={preventDefaults}
>
  <label
    for="image"
    class="flex items-center flex-col p-5 justify-center w-full h-full border-dashed border-4 rounded-md"
  >
    {#if previewImage}
      <img
        src={previewImage}
        alt="Preview"
        class="max-h-full max-w-full object-contain"
      />
    {:else}
      <Lucide icon="ImagePlus" className="h-28 w-28" />
      <div class="text-center">
        Fotoğrafı buraya bırakın veya yüklemek için tıklayın.
      </div>
    {/if}
    <input
      onchange={handleImageChange}
      type="file"
      name="image"
      id="image"
      accept="image/png, image/jpeg, image/jpg"
      hidden
    />
  </label>
</div>
