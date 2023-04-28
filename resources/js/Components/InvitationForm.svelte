<script>
    import { useForm } from '@inertiajs/svelte';
    import FileInput from '../Components/FileInput.svelte';
    import Button from './Button.svelte';
    import { onMount } from 'svelte';
    import ModalFooter from './ModalFooter.svelte';
    import SelectLogoInput from './SelectLogoInput.svelte';
    import { Trash } from '@steeze-ui/heroicons';
    import { Icon } from '@steeze-ui/svelte-icon';

    export let onSuccess = () => {};

    export let isEditing = false;
    export let values = {
        title: '',
        description: '',

        calendar_id: '',
        event_id: '',

        email_domain: '',
        logo_id: null,
        custom_color: '',
        image: null,
        redirect_url: ''
    };

    values.image = values.image ?? null;

    let calendars = null;
    let events = null;
    let form = useForm(values);

    onMount(fetchCalendars);

    async function fetchCalendars() {
        if(isEditing) return;
        const response = await fetch('/api/calendars');
        calendars = await response.json();
        $form.calendar_id = calendars.length ? calendars[0].id : '';
        await fetchEvents();
    }

    async function fetchEvents() {
        if(!$form.calendar_id || isEditing) return;
        events = null;
        const response = await fetch(`/api/events?calendar=${$form.calendar_id}`);
        events = await response.json();
        $form.event_id = events.length ? events[0].id : '';
    }

    function submit() {
        if(!$form.title || !$form.calendar_id || !$form.event_id) return;

        if(isEditing) {
            $form.post('/invitations/' + values.slug, { onSuccess });
        } else {
            $form.post('/invitations', { onSuccess });
        }
    }
</script>

<!-- svelte-ignore a11y-label-has-associated-control a11y-click-events-have-key-events a11y-autofocus -->
<form on:submit|preventDefault={submit} class:pointer-events-none={$form.processing}>
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-6 p-4">
        <label class="col-span-full required">
            <span>Invitation Title</span>
            <input autofocus required bind:value={$form.title} placeholder="Enterprise Business Meeting" type="text">
        </label>
    
        {#if !isEditing}
            <label class="required col-span-3">
                <span>Calendar</span>
        
                <select required bind:value={$form.calendar_id} on:change={fetchEvents}>
                    {#if calendars !== null}
                        {#each calendars as calendar}
                            <option value={calendar.id}>{calendar.title}</option>
                        {:else}
                            <option value="" selected disabled>No Calendars</option>
                        {/each}
                    {/if}
                </select>
            </label>
        
            <label class="required col-span-3">
                <span>Event</span>
        
                <select required bind:value={$form.event_id}>
                    {#if events !== null}
                        {#each events as event}
                            <option value={event.id}>{event.title} ({event.date})</option>
                        {:else}
                            <option value="" selected disabeld>No Events</option>
                        {/each}
                    {/if}
                </select>
            </label>
        {/if}
    
        <label class="col-span-full">
            <span>Description</span>
            <textarea placeholder="Key stakeholders will convene to strategically analyze performance indicators, evaluate operational efficiencies, and synergistically brainstorm actionable insights to enhance stakeholder value." bind:value={$form.description} rows="3"></textarea>
        </label>

        <label class="col-span-2">
            <span>Custom Logo</span>
            <SelectLogoInput bind:selectedId={$form.logo_id}/>
        </label>

        <label class="col-span-2">
            <span>Accent Color</span>
            <input pattern="{'#[0-9A-f]{6}'}" bind:value={$form.custom_color} placeholder="#3b82f6" type="text">
        </label>

        <label class="col-span-2">
            <span>Background Image</span>

            {#if isEditing && $form.image_url}
                <Button on:click={() => $form.image_url = null}
                    icon={Trash} iconClass="text-red-500" iconTheme="outlined"
                    class="text-left flex gap-2 items-center w-full !px-3"
                >Remove Image</Button>
            {:else}
                <FileInput accept=".png,.jpg,.jpeg" bind:value={$form.image}/>
            {/if}
        </label>

        <label class="col-span-3">
            <span title="Only emails ending in @{$form.email_domain || 'profit.biz'} can RSVP">Limit to Email Domain</span>
            <input bind:value={$form.email_domain} placeholder="profit.biz" type="text">
        </label>

        <label class="col-span-3">
            <span>Redirect After RSVP</span>
            <input bind:value={$form.redirect_url} placeholder="https://profit.biz/confirm" type="url">
        </label>
    </div>

    <ModalFooter>
        {#key $form}
            <Button submit={true} disabled={!$form.title || !$form.calendar_id || !$form.event_id}
                class="w-full {$form.processing ? 'animate-pulse' : ''}" style="primary">
                {isEditing ? 'Save Invitation' : 'Create Invitation'}
            </Button>
        {/key}
    </ModalFooter>
</form>