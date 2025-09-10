<template>
    <div class="registration-container">
        <!-- Instructions -->
        <p>Please fill out the provided credit application to open a new commercial account:</p>

        <!-- Credit Application Link -->
        <p>
            <a
                :href="creditApplicationLink"
                target="_blank"
                class="font-weight-bold text-primary"
            >
               <h4> Credit Application</h4>
            </a>
        </p>
    </div>
</template>

<script>
export default {
    name: 'CommercialAccount',
    data() {
        return {
            creditApplicationLink: 'https://www.commercialcreditapps.com/BusinessIQ/credec/caps/pla/loadAppInternalPLAPage?addEditFlag=A&appTemplateId=7hFczQIRXD8WXIzHVmS%2BHg%3D%3D&appTemplateToken=3166',
        };
    },
};
</script>
