<script lang="ts">
	import { onMount } from 'svelte';
	import type { AnimationItem } from 'lottie-web';

	export let animationData: object;
	export let myClass: string = '';

	let animationContainer: HTMLDivElement | null = null;
	let animationInstance: AnimationItem | undefined;

	onMount(async () => {
		const lottie = await import('lottie-web');
		if (animationContainer) {
			animationInstance = lottie.loadAnimation({
				container: animationContainer,
				animationData,
				loop: true,
				autoplay: true
			});
		}
	});

	import { onDestroy } from 'svelte';

	onDestroy(() => {
		if (animationInstance) {
			animationInstance.destroy();
		}
	});
</script>

<div bind:this={animationContainer} class={myClass} />
