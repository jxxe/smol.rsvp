<script>
    import { router } from '@inertiajs/svelte';
    import { Trash } from '@steeze-ui/heroicons';
    import { CalendarCheck, Clipboard, CodeSSlash, Pencil } from '@steeze-ui/remix-icons';
    import { Icon } from '@steeze-ui/svelte-icon';
    import Button from '../Button.svelte';
    import InvitationForm from '../InvitationForm.svelte';
    import Modal from '../Modal.svelte';
    import ModalFooter from '../ModalFooter.svelte';
    import ModalHeader from '../ModalHeader.svelte';

    export let invitation;

    let embedModalOpen = false;
    let deleteModalOpen = false;
    let editModalOpen = false;

    function getUrl() {
        return 'https://smol.rsvp/invitation/' + invitation.slug;
    }

    function getEmbedCode() {
        return `
            <iframe style="display: block; margin: 0 auto; max-width: 800px; width: 100%; height: 400px; border: solid 1px #e5e5e5; border-radius: 8px" src="${getUrl()}"></iframe>
        `.trim();
    }

    function deleteInvitation() {
        deleteModalOpen = false;
        router.delete(`/invitations/${invitation.slug}`);
    }
</script>

<div>
    <div class="flex items-center justify-between group">
        <div class="flex gap-2 items-center px-4">
            <a target="_blank" rel="noreferrer" href="/invitation/{invitation.slug}" class="font-bold truncate">{invitation.title}</a>

            <button class="opacity-0 transition-all group-hover:opacity-100 text-gray-400 hover:text-blue-500" on:click={() => navigator.clipboard.writeText(getUrl())}>
                <Icon class="w-4" src={Clipboard} theme="solid"/>
            </button>
        </div>
    
        <div class="flex items-center divide-x leading-none">
            <span class="px-4 py-3 flex items-center gap-1">
                <Icon class="w-4 text-green-500" src={CalendarCheck} theme="solid"/>
                <span>{invitation.rsvps}</span>
                <span class="hidden sm:inline">RSVP{invitation.rsvps !== 1 ? 's' : ''}</span>
            </span>
    
            <button on:click={() => embedModalOpen = true} class="p-3 hover:bg-gray-100 transition-colors">
                <Icon class="w-4" src={CodeSSlash} theme="solid"/>
            </button>
    
            <button on:click={() => editModalOpen = true} class="p-3 hover:bg-gray-100 transition-colors">
                <Icon class="w-4 text-blue-500" src={Pencil} theme="solid"/>
            </button>
    
            <button on:click={() => deleteModalOpen = true} class="p-3 hover:bg-gray-100 transition-colors">
                <Icon class="w-4 text-red-500" src={Trash} theme="mini"/>
            </button>
        </div>
    </div>

    <Modal bind:isOpen={embedModalOpen}>
        <ModalHeader title="Embed this RSVP on your site"/>

        <div class="p-4">
            <pre class="bg-gray-800 text-white whitespace-pre-wrap p-4 rounded-lg">{getEmbedCode()}</pre>
        </div>

        <ModalFooter>
            <Button on:click={() => embedModalOpen = false}>Close</Button>

            <Button
                style="primary" icon={Clipboard} iconTheme="solid"
                on:click={() => {
                    navigator.clipboard.writeText(getEmbedCode());
                    embedModalOpen = false;
                }}
            >Copy</Button>
        </ModalFooter>
    </Modal>

    <Modal bind:isOpen={deleteModalOpen}>
        <ModalHeader title="Are you sure?"/>

        <div class="p-4 max-w-md space-y-2">
            <p>The event on your calendar will not be deleted, and you can always create a new invitation.</p>
            <p>People who have RSVP’d to <span class="font-bold">{invitation.title}</span> will not be removed from the calendar event.</p>
        </div>

        <ModalFooter>
            <Button on:click={() => deleteModalOpen = false}>Cancel</Button>
            <Button style="destructive" on:click={deleteInvitation}>Delete</Button>
        </ModalFooter>
    </Modal>

    <Modal bind:isOpen={editModalOpen} closeWithEsc={false}>
        <InvitationForm isEditing={true} values={invitation} onSuccess={() => editModalOpen = false}/>
    </Modal>
</div>