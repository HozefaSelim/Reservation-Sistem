<script lang="ts">
  import { enhance } from "$app/forms";
  import Button from "@/lib/components/Button";
  import { Input, Textarea, MultiImageInput } from "@/lib/components/Input";
  import { formHandler } from "@/lib/functions";
</script>

<form
  use:enhance={() =>
    async ({ result }) =>
      formHandler(result)}
  action="?/createRoom"
  method="post"
  class="text-center"
>
  <div class="grid md:grid-cols-2 gap-3 my-10">
    <Input placeholder="Oda Adı" name="name" />
    <Input placeholder="Oda Kapasitesi" name="capacity" />
    <Input placeholder="Oda Günlük Fiyatı" name="price" />
    <Input
      placeholder="İndirim varsa yeni fiyatı yaz"
      name="discounted_price"
    />
    <MultiImageInput />
    <Textarea placeholder="Açıklama" name="description" />
  </div>
  <Button variant="primary" type="submit" className="px-5">Ekle</Button>
</form>
