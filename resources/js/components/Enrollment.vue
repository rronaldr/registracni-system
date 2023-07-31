<template>
    <div class="container-fluid w-50">
        <div class="form-container bg-white rounded shadow mt-4 py-2 px-4">
            <div class="row p-2">
                <div class="col-12">
                    <h3>Prihlaska na udalost</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus ac leo pretium faucibus. Nulla quis diam. Nullam feugiat, turpis at pulvinar vulputate, erat libero tristique tellus, nec bibendum odio risus sit amet ante. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis pulvinar. Sed ac dolor sit amet purus malesuada congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Phasellus et lorem id felis nonummy placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus.
                    </p>
                </div>
            </div>
        </div>

        <div class="form-container bg-white rounded shadow mt-4 py-4 px-4"
            v-for="field in customFields">
            <BaseInput
                v-if="field.type === 'text'"
                :label="field.label"
                :required="field.required"
            />
            <BaseSelect
                v-if="field.type === 'select'"
                :label="field.label"
                :options="field.options"
                :required="field.required"
            />
        </div>

        <div class="form-container bg-white rounded shadow mt-4 py-2 px-4">
            <div class="row p-2">
                <div class="col-12">

                    <p><input type="checkbox"> Souhlasím s <a class="link-primary" href="#">GDPR</a> ....</p>
                    <button class="btn btn-primary" type="submit">Odeslat</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import BaseInput from "./Admin/Form/BaseInput.vue";
    import BaseSelect from "./Admin/Form/BaseSelect.vue";

    const props = defineProps({
        fields: {type: String, required: true},
    })

    let customFields = JSON.parse(props.fields)
    console.log(customFields)

</script>
