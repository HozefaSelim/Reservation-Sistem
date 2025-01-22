<script lang="ts">
  import "../lib/assets/css/app.css";

  import { setUser } from "@/stores/user";

  import { ToastContainer, FlatToast } from "svelte-toasts";

  let { children, data } = $props();

  setUser(data.user);
</script>

{@render children()}
<ToastContainer let:data>
  <FlatToast {data} />
</ToastContainer>
