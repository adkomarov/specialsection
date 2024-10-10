<?php

use yii\db\Schema;
use yii\db\Migration;

class m240801_135617_fieldsforms extends Migration
{
    public function safeUp()
    {


        $this->createTable(
            '{{%fieldsforms}}',
            [
                'id' => $this->primaryKey(11),
                'nameform' => $this->text()->notNull(),
                'fieldform' => $this->text()->notNull(),
                'count_upload_doc' => $this->integer(10)->unsigned()->notNull()->defaultValue(0),
            ],
        );
        $this->batchInsert('{{%fieldsforms}}', ['id','nameform', 'fieldform'], [
            [1,'paid_edu', 'sample_contract_paid_educational'],
            [2,'paid_edu', 'document_on_approval_paid_educational'],
            [3,'paid_edu', 'document_on_how_to_provide_paid_educational'],
            [4,'paid_edu', 'document_on_the_fee_provide_paid_educational'],
            [5,'grants', 'order_of_the_educational_organization_establishment_of_scholarships'],
            [6,'grantsold', 'order_of_the_educational_organization_establishment_creation_scholarship_commission'],
            [7,'grantsold', 'regulations_scholarship_commission_educational_organization'],
            [8,'grantsold', 'regulations_scholarship_provision_and_other_forms_of_material_support'],
            [9,'grantsold', 'regulations_forms_material_support'],
            [10,'grants', 'link_information_formation_of_fee'],
            [11,'document', 'ustav'],
            [13,'document', 'copy_local_normative_act_admission_of_students'],
            [14,'document', 'copy_local_normative_act_classes_of_students'],
            [15,'document', 'copy_local_normative_act_interim_progress_and_attestation_of_students'],
            [16,'document', 'copy_local_normative_act_expulsion_and_reinstatement_of_students'],
            [17,'document', 'copy_local_normative_act_minor_students'],
            [18,'document', 'copy_internal_regulations_of_students'],
            [19,'document', 'copy_internalwork_schedule'],
            [20,'document', 'copy_collective_agreement'],
            [21,'document', 'report_results_of_self-inspection'],
            [22,'document', 'prescriptions_of_bodies_field_of_education'],
            [24,'common', 'information_on_the_founder(s)_of_the_educational_organisation'],
            [25,'common', 'licence_to_carry_out_educational_activities'],
            [26,'common', 'state_accreditation_of_educational_activities_under_implemented_educational_programmes'],
            [27,'edustandarts', 'federal_state_educational_standards'],
            [28,'edustandarts', 'educational_standards'],
            [29,'edustandarts', 'federal_government_requirements'],
            [30,'edustandarts', 'self_imposed_requirements'],
            [31,'inter', 'information_on_concluded_and_planned_agreements_with_foreign_and_or_international_organisations_on_education_and_science_issues'],
            [32,'grants', 'information_on_granting scholarships_to_students'],
            [33,'grants', 'information_on_social_support_measures_for_students'],
            [34,'grants', 'number_of_hostels'],
            [35,'grants', 'number_of_boarding_schools'],
            [36,'grants', 'number_of_places_in_hostels'],
            [37,'grants', 'number_of_dormitory_rooms_adapted_for_use_by_persons_with_disabilities_and_persons_with_special_needs'],
            [38,'grants', 'number_of_places_in_boarding_schools'],
            [39,'grants', 'number_of_residential_premises_in_boarding_schools_adapted_for_use_by_persons_with_disabilities_and_persons_with_special_needs'],
            [40,'budget', 'information_on_the_volume_of_educational_activities_the_financial_provision_of_which_is_carried_out_at_the_expense_of_budgetary_allocations_of_the_federal_budget'],
            [41,'budget', 'information_on_the_volume_of_educational_activities_the_financial_provision_of_which_is_carried_out_at_the_expense_of_the_budgets_of_constituent_entities_of_the_Russian_Federation'],
            [42,'budget', 'information_on_the_volume_of_educational_activities_the_financial_provision_of_which_is_carried_out_at_the_expense_of_local_budgets'],
            [43,'budget', 'information_on_the_volume_of_educational_activities_the_financial_provision_of_which_is_carried_out_under_agreements_on_the_provision_of_paid_educational_services'],
            [44,'budget', 'year_of_reporting'],
            [45,'budget', 'approved_plan_of_financial_and_economic_activity_of_the_educational_organisation_or_budget_estimates_of_the_educational_organisation'],
            [46,'budget', 'information_posted_on_http_bus_gov_ru'],
            [47,'budget', 'information_on_financial_and_material_income'],
            [48,'budget', 'information_on_expenditure_of_financial_and_material_resources'],
            [49,'objects', 'purposeLibr'],
            [50,'objects', 'purposeSport'],
            [51,'objects', 'name_of_the_object'],
            [52,'objects', 'address_of_the_object_location'],
            [53,'objects', 'area_of_the_facility'],
            [54,'objects', 'number_of_place'],
            [55,'objects', 'adaptability_for_use_by_disabled_persons_and_persons_with_disabilities'],
            [56,'objects', 'information_on_ensuring_unhindered_access_to_the_buildings_of_the_educational_organisation'],
            [57,'objects', 'information_about_the_means_of_education_and_training'],
            [58,'objects', 'information_on_adapted_means_of_education_and_upbringing'],
            [59,'objects', 'information_on_access_to_information_systems_and_information_and_telecommunication_networks'],
            [60,'objects', 'information_on_access_to_adapted_information_systems_and_information_and_telecommunications_networks'],
            [61,'objects', 'availability_of_an_electronic_information_and_education_environment_in_the_educational_organisation'],
            [62,'objects', 'number_of_own_electronic_educational_and_information_resources'],
            [63,'objects', 'number_of_third_party_electronic_educational_and_information_resources'],
            [64,'objects', 'number_of_electronic_catalogue_databases'],
            [65,'objects', 'reference_to_the_electronic_educational_resource_to_which_the_students_have_access'],
            [66,'objects', 'reference_to_the_adapted_electronic_educational_resource_to_which_access_is_provided'],
            [67,'objects', 'information_on_the_availability_of_special_technical_means_of_education_for_collective_and_individual_use'],
            [68,'objects', 'information_on_the_availability_of_conditions_for_unhindered_access_to_the_dormitory_boarding_school'],
            [69,'catering', 'information_on_the_conditions_of_nutrition_of_students'],
            [70,'catering', 'information_on_the_conditions_of_health_protection_of_students'],
            [71,'education', 'languages_in_which_education_(training)_is_provided'],
            [72,'education', 'information_on_the_number_of_students_under_educational_programmes_by_sources_of_funding'],
            [73,'education', 'information_on_the_results_of_admission'],
            [74,'education', 'information_on_the_results_of_transfer_reinstatement_and_expulsion_in_the_form_of_an_electronic_document_signed_with_a_simple_electronic_signature'],
            [75,'education', 'information_on_employment_of_graduates_for_each_educational_programme_in_which_graduation_took_place'],
            [76,'education', 'code'],
            [77,'education', 'name_of_profession,_speciality,_including_scientific_speciality,_training_direction'],
            [78,'education', 'educational_programme,_focus,_profile,_code_and_name_of_scientific_specialty'],
            [79,'education', 'number_of_graduates_of_the_previous_academic_year'],
            [80,'education', 'number_of_employed_graduates_of_the_previous_academic_year'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%fieldsforms}}');
    }
}
