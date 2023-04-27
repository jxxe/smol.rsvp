<script>
    import { Icon } from '@steeze-ui/svelte-icon';
    import { ArrowUpTray, Trash } from '@steeze-ui/heroicons';
    import Button from './Button.svelte';

    export let value;
    export let accept = '';
    export let onChange = () => {};

    function pickFile(event) {
        event.preventDefault();

        if(value) {
            value = '';
            return;
        }

        let element = document.createElement('input');
        element.type = 'file';
        element.accept = accept;

        element.addEventListener('change', () => {
            value = element.files[0];
            onChange();
        });

        element.click();
    }
</script>

<Button
    on:click={pickFile} class="w-full"
    iconTheme={value ? 'outlined' : 'mini'} icon={value ? Trash : ArrowUpTray}
    iconClass={value ? 'text-red-500' : 'text-blue-500'}
>{value ? value.name : 'Upload File'}</Button>