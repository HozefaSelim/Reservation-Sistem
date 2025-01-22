<script lang="ts">
  import NavBar from "@/lib/components/NavBar";

  import { ToastContainer, FlatToast } from "svelte-toasts";

  let { children } = $props();
</script>

<NavBar />
{@render children()}
<ToastContainer let:data>
  <FlatToast {data} />
</ToastContainer>
