<script>
    import InvitationRow from '../Components/Dash/InvitationRow.svelte';
    import InvitationForm from '../Components/InvitationForm.svelte';
    import Modal from '../Components/Modal.svelte';
    import ModalHeader from '../Components/ModalHeader.svelte';
    import Logo from '../Components/Logo.svelte';
    import Button from '../Components/Button.svelte';
    import { MailAdd } from '@steeze-ui/remix-icons';

    export let invitations = [];
    let createModalOpen = false;
</script>

<svelte:head>
    <title>Dashboard — smol.rsvp</title>
</svelte:head>

<Modal bind:isOpen={createModalOpen} closeWithEsc={false}>
    <ModalHeader title="Create an Invitation"/>
    <InvitationForm onSuccess={() => createModalOpen = false}/>
</Modal>

<div class="p-4">
    <main class="p-4 max-w-screen-sm mx-auto space-y-4">
        <header class="flex items-center {invitations.length ? 'justify-between' : 'justify-center'}">
            <div class="w-fit">
                <Logo/>
            </div>

            {#if invitations.length}
                <Button icon={MailAdd} on:click={() => createModalOpen = true}>
                    Create Invitation
                </Button>
            {/if}
        </header>
    
        <div class="space-y-4">
            {#if invitations.length}
                <div>
                    <div class="shadow-sm rounded-lg overflow-hidden border divide-y">
                        {#each invitations as invitation}
                            <InvitationRow {invitation}/>
                        {/each}
                    </div>
                </div>
            {/if}
        
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 space-y-3">
                <h2 class="font-bold leading-none text-lg">How does this work?</h2>
        
                <ol class="list-decimal list-inside leading-tight space-y-1">
                    <li><button class="underline text-blue-500" on:click={() => createModalOpen = true}>Create an invitation</button> and select a calendar event</li>
                    <li>Send out the link, put it on posters, etc.</li>
                    <li>When people RSVP, they’ll be invited to the calenar event</li>
                    <li>The event and any changes will be added to attendees’ calendars</li>
                </ol>
            </div>
        
            {#if !invitations.length}
                <div class="border rounded-lg overflow-hidden">
                    <InvitationForm/>
                </div>
            {/if}
        </div>
    </main>
</div>