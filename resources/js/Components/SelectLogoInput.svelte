<script>
    import { onMount } from 'svelte';
    import ModalFooter from './ModalFooter.svelte';
    import Button from './Button.svelte';
    import ModalHeader from './ModalHeader.svelte';
    import Modal from './Modal.svelte';
    import { Icon } from '@steeze-ui/svelte-icon';
    import { Trash } from '@steeze-ui/heroicons';
    import { ImageAdd } from '@steeze-ui/remix-icons';
    import { useForm } from '@inertiajs/svelte';
    import FileInput from './FileInput.svelte';

    export let isOpen = false;
    export let selectedId = null;
    let unsavedSelectedId = null;
    let unsavedFile = null;

    let logos = [];
    let form = useForm({ file: null });

    async function loadData() {
        const request = await fetch('/api/logos');
        logos = await request.json();
    }

    onMount(loadData);

    function onOpenModalButtonClick() {
        if(selectedId) {
            selectedId = null;
        } else {
            isOpen = true;
        }
    }

    function onSelectButtonClick() {
        selectedId = unsavedSelectedId;
        isOpen = false;
        unsavedSelectedId = null;
    }

    function uploadLogo() {
        $form.file = unsavedFile;
        unsavedFile = null;
        $form.post('/api/logos', { onSuccess: loadData });
    }
</script>

<Button
    on:click={onOpenModalButtonClick} class="w-full"
    iconTheme={selectedId ? 'outlined' : 'mini'} icon={selectedId ? Trash : ImageAdd}
    iconClass={selectedId ? 'text-red-500' : 'text-blue-500'}
>{selectedId ? 'Remove Logo' : 'Add Logo'}</Button>

<Modal bind:isOpen>
    <div class="w-full">
        <ModalHeader title="Select a Logo">
            <FileInput onChange={uploadLogo} accept=".png,.jpg,.jpeg" bind:value={unsavedFile}/>
        </ModalHeader>

        <div class="p-4 grid gap-4 sm:grid-cols-2">
            {#each logos as logo}
                <button type="button" on:click={() => unsavedSelectedId = logo.id}>
                    <div
                        class:bg-blue-50={logo.id === unsavedSelectedId}
                        class:border-blue-500={logo.id === unsavedSelectedId}
                        class="p-4 border rounded-lg shadow h-full transition-colors"
                    >
                        <img class="w-full h-full object-contain" src={logo.image_url} width={logo.width} height={logo.height} alt="">
                    </div>
                </button>
            {:else}
                <p>You haven't uploaded any logos yet</p>
            {/each}
        </div>
        
        <ModalFooter>
            {#key unsavedSelectedId}
                <Button on:click={onSelectButtonClick} disabled={unsavedSelectedId === null}
                    class="w-full" style="primary">Select</Button>
            {/key}
        </ModalFooter>
    </div>
</Modal>