<script lang="ts">
  import Button from "@/lib/components/Button";
  import { Input, MultiImageInput, Textarea } from "@/lib/components/Input";
</script>

<form action="" method="post" class="text-center">
  <div class="grid md:grid-cols-2 gap-3 my-10">
    <Input placeholder="Apartman Adı" name="name" />
    <Input placeholder="Araba kapasitesi" name="capacity" />
    <Input placeholder="Apartman Günlük Fiyatı" name="discounted_price" />
    <Input
      placeholder="İndirim varsa yeni fiyatı yaz"
      name="discounted_price"
    />
    <MultiImageInput />
    <Textarea placeholder="Açıklama" name="description" />
    <Textarea
      placeholder="Apartman Adresi"
      name="description"
      className="col-span-2"
    />
  </div>
  <Button variant="primary" type="submit" className="px-5">Ekle</Button>
</form>
