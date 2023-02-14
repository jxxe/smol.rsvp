<script>
    import { Plus } from '@steeze-ui/heroicons';
    import { Icon } from '@steeze-ui/svelte-icon';
    import Button from './Button.svelte';
    import InvitationForm from './InvitationForm.svelte';
    import Logo from './Logo.svelte';
    import Modal from './Modal.svelte';

    let isOpen = false;
</script>

<Modal bind:isOpen={isOpen} closeWithEsc={false}>
    <InvitationForm onSuccess={() => isOpen = false}/>
</Modal>

<div class="p-4">
    <main class="p-4 max-w-screen-sm mx-auto space-y-4">
        <header class="flex items-center justify-between">
            <div class="w-fit">
                <Logo/>
            </div>

            <Button action={() => isOpen = true} class="flex items-center gap-1 text-sm px-2 py-1">
                <Icon class="w-5 text-blue-500" src={Plus}/>
                <span>Create Invitation</span>
            </Button>
        </header>
    
        <div>
            <slot/>
        </div>
    </main>
</div>