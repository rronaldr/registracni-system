<template>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5>
                                Termíny <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Zde vytvořte termíny pro událost"></i>
                            </h5>
                        </div>
                        <div class="col">
                            <a class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#datesModal">
                                <i class="fas fa-plus"></i> Přidat termín
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <TagsForm
                    />
                    <p class="card-text">Zatím nemáte vytvořené žádné termíny k akci</p>
                </div>
            </div>

            <!-- Custom dates modal start -->
            <div class="modal fade" id="datesModal" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Přidat nový termín</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <div class="row g-2 mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Název</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label for="room" class="form-label">Místnost</label>
                                    <input type="text" name="room" class="form-control">
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <label for="capacity" class="form-label">Kapacita</label>
                                    <input type="number" name="capacity" class="form-control">
                                </div>
                                <div class="col-4 text-center">
                                    <label for="limited_capacity" class="form-label">Neomezená kapacita</label>
                                    <input type="checkbox" name="limited_capacity" class="form-check-input">
                                </div>
                                <div class="col-4 text-center">
                                    <label for="substitutes" class="form-label">Povolit náhradníky</label>
                                    <input type="checkbox" name="substitutes" class="form-check-input">
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-8">
                                    <label for="od" class="form-label">Začátek</label>
                                    <input type="date" name="date_from" class="form-control datepicker-here"
                                           data-language="cs" aria-describedby="datepicker">
                                </div>
                                <div class="col-4">
                                    <label for="do" class="form-label">Čas žačátku</label>
                                    <input type="time" name="time_from" class="form-control datepicker-here"
                                           data-language="cs" aria-describedby="datepicker">
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-8">
                                    <label for="od" class="form-label">Konec</label>
                                    <input type="date" name="date_to" class="form-control "
                                           data-language="cs">
                                </div>
                                <div class="col-4">
                                    <label for="do" class="form-label">Čas konce</label>
                                    <input type="time" name="time_to" class="form-control "
                                           data-language="cs">
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col">
                                    <label for="od" class="form-label">Přihlašování od</label>
                                    <input type="datetime-local" name="od" class="form-control"
                                           data-language="cs" placeholder="Vyberte datum">
                                </div>
                                <div class="col">
                                    <label for="do" class="form-label">Přihlašování do</label>
                                    <input type="datetime-local" name="do" class="form-control"
                                           data-language="cs" placeholder="Vyberte datum">
                                </div>
                                <div class="col">
                                    <label for="do" class="form-label">Odhlašování do</label>
                                    <input type="datetime-local" name="do" class="form-control"
                                           data-language="cs" placeholder="Vyberte datum">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Uložit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Custom dates modal end -->
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    id: {type: String, required: false},
    label: {type: String, default: ''},
    modelValue: {type: Boolean, default: false},
})

</script>
