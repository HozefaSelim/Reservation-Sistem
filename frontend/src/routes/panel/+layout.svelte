<script lang="ts">
  import Layout from "@/lib/components/Layout";

  let { children } = $props();
</script>

<Layout>
  {@render children()}
</Layout>
