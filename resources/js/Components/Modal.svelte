<script>
    import { fly, fade } from 'svelte/transition';
    import { circInOut as easing } from 'svelte/easing';

    export let isOpen;
    export let closeWithEsc = true;

    let modalElement;

    function onClickOutside(event) {
        if(!modalElement.contains(event.target) && document.contains(event.target)) {
            isOpen = false;
            event.preventDefault();
        }
    }
</script>

<svelte:window on:keydown={event => {
    if(closeWithEsc && event.key === 'Escape') {
        isOpen = false;
    }
}}/>

<!-- svelte-ignore a11y-click-events-have-key-events -->
{#if isOpen}
    <div on:click={onClickOutside} transition:fade={{ easing, duration: 250 }}
        class="z-10 fixed top-0 left-0 w-screen h-screen bg-black/40 p-4 grid sm:place-items-center">
        <div class="bg-white shadow-md rounded-lg overflow-scroll max-w-screen-sm mx-auto h-fit sm:max-h-none max-h-[70vh]"
            bind:this={modalElement} transition:fly={{ y: 25, easing, duration: 250 }}><slot/></div>
    </div>
{/if}