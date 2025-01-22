<script lang="ts">
  import Button from "@/lib/components/Button";
  import { Input, MultiImageInput, Textarea } from "@/lib/components/Input";
</script>

<form action="" method="post" class="text-center">
  <div class="grid md:grid-cols-2 gap-3 my-10">
    <Input placeholder="Araba Adı" name="name" />
    <Input placeholder="Araba Modeli" name="model" />
    <Input placeholder="Araba Markası" name="brand" />
    <Input placeholder="Araba Plakası" name="license_plate" />
    <Input placeholder="Araba Günlük fiyatı" name="price" />
    <Input
      placeholder="İndirim varsa yeni fiyatı yaz"
      name="discounted_price"
    />
    <MultiImageInput />
    <Textarea placeholder="Açıklama" name="description" />
  </div>
  <Button variant="primary" type="submit" className="px-5">Ekle</Button>
</form>
