var app = new Vue({
    el: "#app",
    vuetify: new Vuetify(),
    data: {
        e1: 1,
        selectedMilestone: '',
        milestone: 0,
        milestoneName: '',
        award_year: 0,
        isRetiringThisYear: 0,
        retirementDate: '',
        certificateName: '',
        isRetroactive: 0,
        awardReceived:0,
        isBcgeuMember: false,
        registered2019: 0,


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
        officeCity: 0,
        officeCityName: '',
        officePostalCode: '',
        officePhone: '',
        officeExtension: '',

        homeMailPrefix: '',
        homeSuite: '',
        homeStreetAddress: '',
        homeCity: 0,
        homeCityName: '',
        homePostalCode: '',
        homePhone: '',

        supervisorFirstName: '',
        supervisorLastName: '',
        supervisorMailPrefix: '',
        supervisorSuite: '',
        supervisorStreetAddress: '',
        supervisorCity: 0,
        supervisorCityName : '',
        supervisorPostalCode: '',
        supervisorEmail: '',


        isDeclared: false,
        isOptedIn: 1,

        errorsStep1: [],
        errorsStep2: [],
        errorsStep3: [],
        errorsStep4: [],


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


        highlightedAward: 1,

        //MAGIC NUMBERS
        //IDs of Awards with options
        watchID: 9,
        bracelet35ID: 12,
        bracelet45ID: 29,
        bracelet50ID: 48,
        pecsf25ID: 49,
        pecsf30ID: 50,
        pecsf35ID: 51,
        pecsf40ID: 52,
        pecsf45ID: 53,
        pecsf50ID: 54,


        watchColour: 'Select a colour',
        watchSize: 'Select Watch Size',
        strapType: 'Choose Strap',
        watchEngraving: null,
        braceletSize: 'Choose Size',

        pecsfRegion: 0,
        pecsfRegionName: '',
        pecsfName: '',
        donationType: 'pool',
        pecsfCharity1: 0,
        pecsfCharity2: 0,
        pecsfCharity1Name: '',
        pecsfCharity2Name: '',

        //EDIT FORM VARS
        formIsValid: false,
        editFormErrors: false,

        accessRecipientSelections:  '',
        accessGuestSelections :     '',
        dietRecipientSelections:    '',
        dietGuestSelections:        '',
        originalAward:              '',

        errorsOptions: '',

        // Regex for emails:
        reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/


    },
    computed: {
        displayWatch : function () {
            return (this.selectedAward == this.watchID);
        },
        displayBracelet : function () {
            if (this.selectedAward == this.bracelet35ID || this.selectedAward == this.bracelet45ID || this.selectedAward == this.bracelet50ID) {
                return true;
            } else {
                return false;
            }

        },
        displayPecsf: function () {
            switch (parseInt(this.selectedAward)) {
                case parseInt(this.pecsf25ID) :
                    return true;
                case parseInt(this.pecsf30ID) :
                    return true;
                case parseInt(this.pecsf35ID) :
                    return true;
                case parseInt(this.pecsf40ID) :
                    return true;
                case parseInt(this.pecsf45ID) :
                    return true;
                case parseInt(this.pecsf50ID) :
                    return true;
                default:
                    return false;
            }
        }

    },

    methods: {


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
        setPecsfRegionName : function (e) {
            if (e.target.options.selectedIndex > -1) {
                this.pecsfRegionName = e.target.options[e.target.options.selectedIndex].text
            }
        },
        setCharity1Name : function (e) {
            if (e.target.options.selectedIndex > -1) {
                this.pecsfCharity1Name = e.target.options[e.target.options.selectedIndex].text
            }
        },
        setCharity2Name : function (e) {
            if (e.target.options.selectedIndex > -1) {
                this.pecsfCharity2Name = e.target.options[e.target.options.selectedIndex].text
            }
        },

        selectAward: function(awardid) {
            this.selectedAward = awardid;
            this.$vuetify.goTo('#award-button');
        },

        parseAwardOptions : function () {
            //If watch
            console.log('Parsing the things!');
            console.log('');

            if (this.selectedAward == this.watchID) {
                console.log('Watch detected');
                this.parseWatchOptions();
            }
            //If bracelet
            if (this.selectedAward == this.bracelet35ID || this.selectedAward == this.bracelet45ID || this.selectedAward == this.bracelet50ID) {
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
        checkAwardReceived : function () {
            (this.registered2019 == 0) ? this.awardReceived = 0 : null;
        },

        parseBraceletOptions : function () {
            this.braceletSize = this.awardOptions.bracelet_size;
        },
        parseWatchOptions : function () {
            console.log(this.awardOptions);
            console.log('Watch options parsed including ' + this.awardOptions.watch_colour);

            this.watchColour    = this.awardOptions.watch_colour;
            this.watchSize      = this.awardOptions.watch_size;
            this.strapType      = this.awardOptions.strap_type;
            this.watchEngraving = this.awardOptions.watch_engraving;
        },

        isEmailValid: function(e) {
            return (e == "")? "" : (this.reg.test(e)) ? true : false;
        },

        // This is allowed to be empty.
        altEmailValidation: function(e) {
            if (e == '') {
                return true
            }
            else {
                return (e == "") ? "" : (this.reg.test(e)) ? true : false;
            }
        },

        // These methods are to give user instant feedback on emails - as per: https://codepen.io/CSWApps/pen/MmpBjV
        // Not really working yet - I think they need corresponding CSS
        isGovtEmailValid: function() {
            return (this.govtEmail == "")? "" : (this.reg.test(this.govtEmail)) ? 'has-success' : 'has-error';
        },
        isAltEmailValid: function() {
            return (this.altEmail == "")? "" : (this.reg.test(this.altEmail)) ? 'has-success' : 'has-error';
        },

        isSupervisorEmailValid: function() {
            return (this.supervisorEmail == "")? "" : (this.reg.test(this.altEmail)) ? 'has-success' : 'has-error';
        },
        advanceCarouselFromMilestone() {
            if (this.awardReceived) {
                this.e1 = 3;
            }  else {
                this.e1 = 2;
            }
        },

        validateStep1 : function () {
            this.errorsStep1 = [];
            //Did they put in a milestone year?
            if (this.milestone == 0) {
                this.errorsStep1.push('You must select a milestone.');
            }
            //Did they specify a qualifying year

            if (this.award_year == 0) {
                this.errorsStep1.push('You must select a qualifying year.');
            }

            //Are they a 25 year milestone but leave the certificate name blank?
            if (this.milestone == 1 && this.certificateName.length < 3) {
                this.errorsStep1.push('Please indicate your name as you would like it on the certificate');
            }

            //Did they say they registered in 2019 but indicate an award year after that?
            if (this.registered2019 != 0 && this.award_year > 2019) {
                this.errorsStep1.push('Please ensure your milestone information is correct.');
            }


            //Did they indicate a retirement date that's not this year.
            if (this.retirementDate) {
                $intYear = parseInt(this.retirementDate.substr(0,4));
                if ($intYear != 2021) {
                    this.errorsStep1.push('Please ensure your retirement date is within the calendar year 2021');
                }
            }



            if (this.errorsStep1.length == 0) {
                //Did they register last year? If so, skip the award step.
                (this.registered2019 == 0) ? this.e1 = 2 : this.e1 = 3;
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
            this.validateAwardInfo();

            if (this.errorsStep2.length == 0) {

                this.e1 = 3;
            }
        },
        validateStep3 : function () {
            this.errorsStep3 = [];
            //Did include an employee number?
            if (this.employeeID.length < 2 || this.employeeID.length > 11) {
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
            /*
            //Did they include their gov email address?
            if (this.govtEmail.length < 6 ) {
                this.errorsStep3.push('You must input your government email address');
            } */

            // Validating govtEmail
            if(this.isEmailValid(this.govtEmail) == false) {
                this.errorsStep3.push("You must enter a valid government email address.");
            }
            // Alt email validation - can be empty or could also need to be checked.
            if(this.altEmailValidation(this.altEmail) == false ) {
                this.errorsStep3.push("You must enter a valid alternative email address.");
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
            if (this.officeCity == 0) {
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
            if (this.homeCity == 0) {
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
            } else {
                this.scrollToTop();
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
            // Supervisor email validation.
            if(this.isEmailValid(this.supervisorEmail) == false) {
                this.errorsStep4.push("You must enter a valid supervisor email address.");
            }
            //Did they include a supervisor street address
            if (this.supervisorStreetAddress.length < 4) {
                this.errorsStep4.push('You must input your supervisor\'s office address');
            }
            //Did they include a supervisor city
            if (this.supervisorCity == 0) {
                this.errorsStep4.push('You must input your supervisor\'s office city');
            }
            //Did they include a supervisor postal code
            if (this.supervisorPostalCode.length != 7) {
                this.errorsStep4.push('You must input your supervisor\'s office postal code')
            }

            if (this.errorsStep4.length == 0) {
                console.log ('no errors on step 4');
                this.e1 = 5;
            } else {
                this.scrollToTop();
            }
        },
        validateAwardInfo: function () {
            if (this.displayBracelet) {
                //validate that bracelet info is present
                if (this.braceletSize == 'Choose Size') {
                    this.errorsStep2.push('Please select a size for your bracelet')
                }
            }
            if (this.displayWatch) {
                //validate that watch info is present
                if (this.watchColour == 'Select a colour') {
                    this.errorsStep2.push('Please select a colour for your watch')
                }
                if (this.watchSize == 'Select Watch Size') {
                    this.errorsStep2.push('Please select a size for your watch')
                }
                if (this.strapType == 'Choose Strap') {
                    this.errorsStep2.push('Please select a strap type for your watch')
                }
                if (this.watchEngraving == null) {
                    this.errorsStep2.push('Please enter a name for your watch engraving')
                }

            }
            if (this.displayPecsf) {
                //validate that pecsf info is present
                if (this.pecsfName == '') {
                    this.errorsStep2.push('Please enter a name for your PECSF donation')
                }
                if (this.pecsfRegion == 0 ) {
                    this.errorsStep2.push('Please enter a name for your PECSF region');
                }
                if (this.donationType != 'pool') {
                    if (this.pecsfCharity1 == 0) {
                        this.errorsStep2.push('Please enter a charity for your donation or choose to donate to the pool for your region.')
                    }
                    if (this.donationType == 'two-charities' && this.pecsfCharity2 == 0) {
                        this.errorsStep2.push('Please enter a second charity for your donation, or choose to donate to a single charity or the pool')
                    }
                }
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

