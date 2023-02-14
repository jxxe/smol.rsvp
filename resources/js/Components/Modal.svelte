<script>
    import { fly, fade } from 'svelte/transition';
    import { circInOut as easing } from 'svelte/easing';

    export let isOpen;
    export let closeWithEsc = true;
    let modalElement;

    function closeModal(event) {
        if(modalElement.contains(event.target)) {
            event.preventDefault();
        } else {
            isOpen = false;
        }
    }
</script>

<svelte:window on:keydown={event => {
    if(closeWithEsc && event.key === 'Escape') {
        closeModal();
    }
}}/>

{#if isOpen}
    <!-- svelte-ignore a11y-click-events-have-key-events -->
    <div on:click={closeModal} transition:fade={{ easing, duration: 250 }} class="p-4 fixed top-0 left-0 w-screen h-screen bg-black/40 grid sm:items-center justify-center">
        <div transition:fly={{ y: 25, easing, duration: 250 }} bind:this={modalElement} class="bg-white shadow-md rounded-lg w-full max-h-[80vh] max-w-screen-sm overflow-scroll">
            <slot/>
        </div>
    </div>
{/if}