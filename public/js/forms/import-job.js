/**
 *
 */
document.addEventListener("DOMContentLoaded", function () {
    let selectorImportJobShow             = document.querySelectorAll('[data-target="#error-job-show"]');
    let retryFailedJobs                   = document.querySelectorAll(".retry-failed-job");
    let selectorImportJobShowTitle        = document.querySelector('#error-job-show--title');
    let selectorTbody                     = document.querySelector('#error-job-show .modal-body #error-job-show--tbody');
    let retryFailedJobUrl                 = document.querySelector("[data-retry-failed-job-url]").dataset.retryFailedJobUrl;
    let selectorImportJobShowSaveAndRetry = document.querySelector('#error-job-show--save-and-retry');
    let firstKey                          = document.querySelector("[data-first-key]").dataset.firstKey;
    let selectorImportJobShowSave         = document.querySelector('#error-job-show--save');
    let updateFailedJobUrl                = document.querySelector("[data-update-failed-job-url]").dataset.updateFailedJobUrl;
    let errorJobId                        = document.querySelector("[data-error-job-id]").dataset.errorJobId;
    let inputValues                       = [];
    let importData                        = {};
    let uuids                             = [];
    let importDataKeys                    = Object.keys(importData);
    let uuid                              = "";
    let modalTbody                        = "";
    let btnEvent                          = null;
    let inputs                            = null;
    let inputValue                        = [];
    let self                              = this;

    document.querySelector("#firstKeyPlace").innerHTML = firstKey;

    /**
     * Retry failed jobs
     */
    retryFailedJobs.forEach((retryBtn) => {
        retryBtn.addEventListener("click", (retryEvent) => {
            retryEvent.preventDefault();

            self.successRetry(retryEvent.target, '', '', true);
            self.successRetry(selectorImportJobShowSaveAndRetry, '', '', true);

            uuids.push(retryEvent.target.parentNode.dataset.uuid);
            console.log(errorJobId);
            axios.post(retryFailedJobUrl, {uuids, id: errorJobId})
                .then((response) => {
                    self.successRetry(retryEvent.target, 'btn-secondary', 'btn-success', true);
                    self.successRetry(selectorImportJobShowSaveAndRetry, 'btn-light', 'btn-success', true);

                    new Noty({
                        type: "success",
                        text: response.data.message,
                    }).show();
                })
                .catch(err => {
                    self.successRetry(retryEvent.target, 'btn-success', 'btn-secondary', false);
                    self.successRetry(selectorImportJobShowSaveAndRetry.target, 'btn-success', 'btn-light', false);

                    new Noty({
                        type: "error",
                        text: err.response.data,
                    }).show();

                    console.error(err);
                })
                .finally(() => {
                    uuids = [];
                });
        })
    });

    /**
     *
     */
    selectorImportJobShowSave.addEventListener('click', (e) => {
        self.successRetry(e.target, '', '', true);

        self.processData().updateDataSet().updateFailedJob(e, inputValues);
    });

    /**
     *
     */
    selectorImportJobShowSaveAndRetry.addEventListener('click', (e) => {
        self.successRetry(selectorImportJobShowSave, '', '', true);

        self.successRetry(e.target, '', '', true);
        self.successRetry(btnEvent.target.nextElementSibling, '', '', true);

        self.processData().updateDataSet().updateFailedJob(e, inputValues, true);
    });

    /**
     *
     * @returns {*}
     */
    self.processData = () => {
        inputs     = selectorTbody.querySelectorAll("input.job-field");
        inputValue = [];

        inputs.forEach((ele) => {
            inputValue.push(ele.value === "" ? null : ele.value);
        });

        inputValues.push(inputValue);
        uuids.push(uuid);

        return self;
    }

    /**
     *
     * @param {Event} e
     * @param inputValues
     * @param retry
     */
    self.updateFailedJob = (e, inputValues, retry = false) => {
        if (inputValues.length === uuids.length) {
            axios.post(updateFailedJobUrl, {updateImportData: inputValues, uuids, id: errorJobId, retry})
                .then(response => {

                    if (retry) {
                        self.successRetry(e.target, 'btn-light', 'btn-success', true);
                        self.successRetry(btnEvent.target.nextElementSibling, 'btn-secondary', 'btn-success', true);
                    } else {
                        self.successRetry(e.target, '', '', false);
                    }

                    new Noty({
                        type: "success",
                        text: response.data.message,
                    }).show();
                })
                .catch(err => {
                    self.successRetry(selectorImportJobShowSave, '', '', false);

                    self.successRetry(e.target, 'btn-success', 'btn-light', false);
                    self.successRetry(btnEvent.target.nextElementSibling, 'btn-success', 'btn-secondary', false);

                    new Noty({
                        type: "error",
                        text: err.response.data,
                    }).show();

                    console.error(err);
                })
                .finally(() => {
                    self.resetPayload();
                });
        } else {
            new Noty({
                type: "error",
                text: "Something went wrong!",
            }).show();
        }
        return self;
    }

    /**
     *
     * @returns {*}
     */
    self.updateDataSet = () => {
        let newImportData = {};
        importDataKeys.forEach((key, index) => {
            newImportData[key] = inputValue[index];
        });

        importData                     = JSON.stringify(newImportData);
        btnEvent.target.dataset.import = importData;

        return self;
    }

    /**
     *
     */
    self.importJobModalShow = () => {
        selectorImportJobShow.forEach(viewButton => {
            viewButton.addEventListener('click', (e) => {
                btnEvent = e;

                self.resetPayload();

                if (!btnEvent.target.nextElementSibling.disabled) {
                    self.successRetry(selectorImportJobShowSaveAndRetry, 'btn-success', 'btn-light', false);
                    self.successRetry(selectorImportJobShowSave, '', '', false);
                } else {
                    self.successRetry(selectorImportJobShowSave, '', '', true);
                }

                modalTbody                           = "";
                selectorImportJobShowTitle.innerHTML = "Import Data - <strong>"
                                                       + viewButton.closest('tr').firstChild.innerHTML
                                                       + "</strong>";
                importData                           = JSON.parse(e.target.dataset.import);
                importDataKeys                       = Object.keys(importData)

                uuid = e.target.parentNode.dataset.uuid;


                importDataKeys.forEach((key, index) => {
                    modalTbody += `<tr>
                        <td>${index + 1}</td>
                        <td>${key}</td>
                        <td>
                            <input class="form-control job-field" name="${key}"
                                    value="${importData[key]
                                             === null
                                             || (importData[key]).toString().toLowerCase()
                                             === 'null'
                                             ? ''
                                             : importData[key]}"/>
                        </td>
                    </tr>`;
                })

                selectorTbody.innerHTML = modalTbody;
            });
        });
    }

    /**
     *
     */
    self.resetPayload = () => {
        uuids       = [];
        inputValues = [];
    }

    /**
     *
     * @param target
     * @param removeClass
     * @param addClass
     * @param disabled
     */
    self.successRetry = function (target, removeClass = '', addClass = '', disabled = false) {
        disabled ? target.disabled = true : target.removeAttribute("disabled");
        removeClass ? target.classList.remove(removeClass) : false;
        addClass ? target.classList.add(addClass) : false;
    }

    /**
     *
     */
    self.importJobModalShow();
});

