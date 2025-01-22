<script lang="ts">
  import Lucide from "$lib/components/Lucide";

  let { previewImages = [] } = $props();

  const handleImageChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const files = input.files;

    if (files) {
      Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = () => {
          if (reader.result) {
            previewImages = [...previewImages, reader.result as string];
          }
        };
        reader.readAsDataURL(file);
      });
    }
  };

  const handleDrop = (event: DragEvent) => {
    event.preventDefault();
    const files = event.dataTransfer?.files;

    if (files) {
      Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = () => {
          if (reader.result) {
            previewImages = [...previewImages, reader.result as string];
          }
        };
        reader.readAsDataURL(file);
      });
    }
  };

  const preventDefaults = (event: DragEvent) => {
    event.preventDefault();
    event.stopPropagation();
  };

  const removeImage = (index: number) => {
    previewImages = previewImages.filter((_, i) => i !== index);
  };
</script>

<!-- svelte-ignore a11y_no_static_element_interactions -->
<div
  class=" h-auto bg-white rounded-lg p-2"
  ondrop={handleDrop}
  ondragover={preventDefaults}
  ondragenter={preventDefaults}
  ondragleave={preventDefaults}
>
  <label
    for="image"
    class="flex items-center flex-col p-5 justify-center w-full h-40 border-dashed border-4 rounded-md"
  >
    <Lucide icon="ImagePlus" className="h-28 w-28" />
    <div class="text-center">
      Fotoğrafları buraya bırakın veya yüklemek için tıklayın.
    </div>
    <input
      onchange={handleImageChange}
      type="file"
      name="images"
      id="image"
      accept="image/png, image/jpeg, image/jpg"
      multiple
      hidden
    />
  </label>

  <!-- {#if previewImages.length > 0}
    <div class="flex flex-wrap gap-2 mt-4">
      {#each previewImages as image, index}
        <div class="relative w-14 h-14 border-2 rounded-md overflow-hidden">
          <img src={image} alt="Preview" class="w-full h-full object-cover" />
          <button
            type="button"
            class="absolute top-1 left-1 bg-red-500 text-white w-5 h-5 rounded-full"
            onclick={() => removeImage(index)}
          >
            &times;
          </button>
        </div>
      {/each}
    </div>
  {/if} -->
</div>
