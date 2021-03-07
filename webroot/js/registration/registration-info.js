var app = new Vue({
    el: "#app",
    vuetify: new Vuetify(),
    data: {
        e1: 1,
        selectedMilestone: '',
        milestone: 'Select Milestone',
        milestoneName: '',
        award_year: 'Select Year',
        isRetiringThisYear: 0,
        retirementDate: '',
        certificateName: '',
        isRetroactive: 0,
        isBCGEU: 0,

        employeeID: '',
        firstName: '',
        lastName: '',

        selectedAward: -1,
        awardName: '',
        awardDescription: '',
        awardOptions: [],
        awardImage: '',

        donationRegion: '',
        donationCharity1: '',
        donationCharity2: '',

        govtEmail: '',
        altEmail: '',

        ministry: 'Select Ministry',
        ministryName : '',
        ministryBranch: '',

        officeMailPrefix: '',
        officeSuite: '',
        officeStreetAddress: '',
        officeCity: 'Select A City',
        officeCityName: '',
        officePostalCode: '',
        officePhone: '',
        officeExtension: '',

        homeMailPrefix: '',
        homeSuite: '',
        homeStreetAddress: '',
        homeCity: 'Select A City',
        homeCityName: '',
        homePostalCode: '',
        homePhone: '',

        supervisorFirstName: '',
        supervisorLastName: '',
        supervisorMailPrefix: '',
        supervisorSuite: '',
        supervisorStreetAddress: '',
        supervisorCity: 'Select A City',
        supervisorCityName : '',
        supervisorPostalCode: '',
        supervisorEmail: '',


        isDeclared: false,
        isOptedIn: 1,

        errorsStep1: [],
        errorsStep2: [],
        errorsStep3: [],
        errorsStep4: [],

        watchColour: null,
        watchSize: null,
        strapType: null,
        watchEngraving: null,
        braceletSize: null,

        awardSelected: false,
        awardConfirmed: false,
        identifyingInfoInput: false,
        officeAddressInput: false,
        homeAddressInput: false,
        supervisorInput: false,
        informationConfirmed: false,
        showOptions: true,

        inputDonationType: false,
        inputCharity1: false,
        inputCharity2: false,
        testShow: false,

        pecsfRegion: 0,
        donationType: false,
        highlightedAward: 1,

        //MAGIC NUMBERS
        //IDs of Awards with options
        watchID: 9,
        bracelet35ID: 12,
        bracelet45ID: 46,
        pecsf25ID: 49,
        pecsf30ID: 50,
        pecsf35ID: 51,
        pecsf40ID: 52,
        pecsf45ID: 53,
        pecsf50ID: 54,

        //EDIT FORM VARS
        formIsValid: false,
        editFormErrors: false,


        accessRecipientSelections:  '',
        accessGuestSelections :     '',
        dietRecipientSelections:    '',
        dietGuestSelections:        '',
        originalAward:              '',

        errorsOptions: '',


},
    methods: {
        beforeMount : function () {
          this.parseAwardOptions();
        },

        filterOfficePhoneNumber : function () {
            this.officePhone         = Inputmask.format(this.officePhone, {"mask" : "(999) 999-9999", "placeholder": ""});
        },
        filterHomePhoneNumber : function () {
            this.homePhone          = Inputmask.format(this.homePhone, {"mask" : "(999) 999-9999" , "placeholder": ""});
        },
        filterOfficePostalCode : function () {
            this.officePostalCode   = Inputmask.format(this.officePostalCode, {"mask" : "A9A 9A9", "placeholder": ""});
        },
        filterHomePostalCode : function () {
            this.homePostalCode     = Inputmask.format(this.homePostalCode, {"mask" : "A9A 9A9", "placeholder": ""});
        },
        filterSupervisorPostalCode : function () {
            this.supervisorPostalCode = Inputmask.format(this.supervisorPostalCode, {"mask" : "A9A 9A9", "placeholder": ""});
        },
        filterOfficeExtension : function () {
            this.officeExtension = Inputmask.format(this.officeExtension, {"mask": "9[999]"});
        },
        filterGovtEmail : function () {
            this.govtEmail = this.filterEmail(this.govtEmail);
        },
        filterAltEmail : function () {
            this.altEmail = this.filterEmail(this.altEmail);
        },
        filterSupervisorEmail : function () {
            this.supervisorEmail = this.filterEmail(this.supervisorEmail);
        },
        filterEmail : function (emailString) {
            return Inputmask.format(emailString, {
                mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
                greedy: false,
                onBeforePaste: function (pastedValue, opts) {
                    pastedValue = pastedValue.toLowerCase();
                    return pastedValue.replace("mailto:", "");
                },
                definitions: {
                    '*': {
                        validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                        casing: "lower"
                    }
                }
            });
        },

        //TODO: Reduce the redundant functions to a single parameterized function call.
        setMilestoneName : function(e) {
            if (e.target.options.selectedIndex > -1) {
                this.milestoneName = e.target.options[e.target.options.selectedIndex].text
            }
        },
        setMinistryName : function(e) {
            if (e.target.options.selectedIndex > -1) {
                this.ministryName = e.target.options[e.target.options.selectedIndex].text
            }
        },
        setOfficeCityName : function(e) {
            if (e.target.options.selectedIndex > -1) {
                this.officeCityName = e.target.options[e.target.options.selectedIndex].text
            }
        },
        setHomeCityName : function (e) {
            if (e.target.options.selectedIndex > -1) {
                this.homeCityName = e.target.options[e.target.options.selectedIndex].text
            }
        },
        setSupervisorCityName : function (e) {
            if (e.target.options.selectedIndex > -1) {
                this.supervisorCityName = e.target.options[e.target.options.selectedIndex].text
            }
        },

        selectAward: function(awardid) {
            this.selectedAward = awardid;
            this.$vuetify.goTo('#award-button');
        },

        parseAwardOptions : function () {
            //If watch
            if (this.selectedAward == this.watchID) {
                console.log('Watch detected');
                this.parseWatchOptions();
            }
            //If bracelet
            if (this.selectedAward == this.bracelet35ID || this.selectedAward == this.bracelet45ID) {
                this.parseBraceletOptions();
            }
            //If PECSF
            if (this.selectedAward == this.pecsf25ID || this.selectedAward == this.pecsf30ID || this.selectedAward == this.pecsf35ID || this.selectedAward == this.pecsf40ID || this.selectedAward == this.pecsf45ID || this.selectedWard == this.pecsf50ID) {
               if (this.pecsfCharity2) {
                   this.donationType = 'two-charities';
               }
               if (this.pecsfCharity1 && !this.pecsfCharity2) {
                   this.donationType = 'single-charity';
               }
               if (!this.pecsfCharity1) {
                   this.donationType = 'pool';
               }
            }
        },

        parseBraceletOptions : function () {
            this.braceletSize = this.awardOptions.bracelet_size;
        },
        parseWatchOptions : function () {
            console.log('Watch options parsed including ' + this.awardOptions.watch_colour);

            this.watchColour    = this.awardOptions.watch_colour;
            this.watchSize      = this.awardOptions.watch_size;
            this.strapType      = this.awardOptions.strap_type;
        },





        validateStep1 : function () {
            this.errorsStep1 = [];
            //Did they put in a milestone year?
            if (this.milestone == 'Select Milestone') {
                this.errorsStep1.push('You must select a milestone.');
            }
            //Did they indicate a qualifying year?
            if (this.award_year == 0) {
                this.errorsStep1.push('You must select a qualifying year.');
            }

            //Did they reach this milestone in 2021 but also say they registered for an LSA in 2019
            if (this.isRetroactive && (this.award_year > 2019)) {
                this.errorsStep1.push('Please ensure your milestone information is correct.');
            }


            if (this.errorsStep1.length == 0) {
                console.log ('no errors on step 1');
                this.e1 = 2;
            }

        },
        scrollToTop : function () {
            this.$vuetify.goTo('#carousel-top')
        },
        validateStep2 : function () {
            this.errorsStep2 = [];
            //Did they select an award?
            if (this.selectedAward == -1) {
                this.errorsStep2.push('You must select an award');
            }

            //Did they indicate an award that requires options?




            if (this.errorsStep2.length == 0) {
                console.log ('no errors on step 2');
                this.e1 = 3;
            }
        },
        validateStep3 : function () {
            this.errorsStep3 = [];
            //Did include an employee number?
            if (this.employeeID.length < 5 || this.employeeID.length > 10) {
                this.errorsStep3.push('You must input a valid employee number');
            }
            //Did they include their first name?
            if (this.firstName.length < 2 || this.firstName.length > 50) {
                this.errorsStep3.push('You must input your first name.');
            }
            //Did they include their last name?
            if (this.lastName.length < 2 || this.lastName.length > 50) {
                this.errorsStep3.push('You must input your last name');
            }
            //Did they include their gov email address?
            if (this.govtEmail.length < 6 ) {
                this.errorsStep3.push('You must input your government email address');
            }
            //Did they specify their ministry?
            if (this.ministry == 'Select Ministry') {
                this.errorsStep3.push('You must select your ministry');
            }
            //Did they indicate their current branch?
            if (this.ministryBranch == '') {
                this.errorsStep3.push('You must input your branch');
            }
            //Did they include an office street address?
            if (this.officeStreetAddress.length < 4) {
                this.errorsStep3.push('You must input your office address');
            }
            //Did they include an office city?
            if (this.officeCity == 'Select A City') {
                this.errorsStep3.push('You must select your office city');
            }
            //Did they include a postal code?
            if (this.officePostalCode.length != 7) {
                this.errorsStep3.push('You must input your office postal code');
            }
            //Did they include a phone number?
            if (this.officePhone.length != 14) {
                this.errorsStep3.push('You must input your office phone number');
            }
            //Did they include a home street address?
            if (this.homeStreetAddress.length < 4) {
                this.errorsStep3.push('You must input your home address');
            }
            //Did they include a home city?
            if (this.homeCity == 'Select A City') {
                this.errorsStep3.push('You must input your home city');
            }
            //Did they include a home postal code?
            if (this.homePostalCode.length != 7) {
                this.errorsStep3.push('You must input your home postal code');
            }
            //Did they include a home phone number?
            if (this.homePhone.length != 14) {
                this.errorsStep3.push('You must input your home phone number');
            }

            if (this.errorsStep3.length == 0) {
                console.log ('no errors on step 3');
                this.e1 = 4;
            }
        },
        validateStep4 : function () {
            this.errorsStep4 = [];
            //Did they include a supervisor first name
            if (this.supervisorFirstName.length < 2 || this.supervisorFirstName.length > 50) {
                this.errorsStep4.push('You must input your supervisor\'s first name');
            }
            //Did they include a supervisor surname
            if (this.supervisorLastName.length < 2 || this.supervisorLastName.length > 50) {
                this.errorsStep4.push('You must input your supervisor\'s last name')
            }
            //Did they include a supervisor email
            if (this.supervisorEmail.length < 6) {
                this.errorsStep4.push('You must input your supervisor\'s government email address');
            }
            //Did they include a supervisor street address
            if (this.supervisorStreetAddress.length < 4) {
                this.errorsStep4.push('You must input your supervisor\'s office address');
            }
            //Did they include a supervisor city
            if (this.supervisorCity == 'Select A City') {
                this.errorsStep4.push('You must input your supervisor\'s office city');
            }
            //Did they include a supervisor postal code
            if (this.supervisorPostalCode.length != 7) {
                this.errorsStep4.push('You must input your supervisor\'s office postal code')
            }

            if (this.errorsStep4.length == 0) {
                console.log ('no errors on step 4');
                this.e1 = 5;
            }
        },
        validateForm : function () {
            this.validateStep1();
            this.validateStep2();
            this.validateStep3();
            this.validateStep4();

            if (this.errorsStep1.length == 0 && this.errorsStep2.length == 0 && this.errorsStep3.length == 0 && this.errorsStep4.length == 0) {
                console.log('No errors on form');
                this.formIsValid = true;
                this.editFormErrors = false;
            } else {
                console.log('Some errors on form');

                this.formIsValid = false;
                this.editFormErrors = true;
                this.$vuetify.goTo('#app');
            }
        }

    }
});

