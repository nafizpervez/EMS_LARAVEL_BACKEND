<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExtendedUserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' =>''.$this->id,
            'type' => 'ExtendedUserDetail',
            'attributes' => [
                'employment_term' => $this->employment_term,
                'bank_account_for_salary' => $this->bank_account_for_salary,
                'bank_name' => $this->bank_name,
                'is_two_factor_auth' => $this->is_two_factor_auth,
                'supervisor' => $this->supervisor,
                'insurance_category' => $this->insurance_category,
                'tin' => $this->tin,
                'pf_code' => $this->pf_code,
                'pf_contribution' => $this->pf_contribution,
                'date_of_birth' => $this->date_of_birth,
                'marital_status' => $this->marital_status,
                'fathers_name' => $this->fathers_name,
                'mothers_name' => $this->mothers_name,
                'spouse_name' => $this->spouse_name,
                'nationality' => $this->nationality,
                'nid' => $this->nid,
                'gender' => $this->gender,
                'religion' => $this->religion,
                'number_of_child' => $this->number_of_child,
                'passport_number' => $this->passport_number,
                'mailing_address' => $this->mailing_address,
                'personal_email' => $this->personal_email,
                'personal_contact_number' => $this->personal_contact_number,
                'emergency_contact_number' => $this->emergency_contact_number,
                'permanent_address' => $this->permanent_address,
                'official_intercom_extension' => $this->official_intercom_extension,
                'skype_id' => $this->skype_id,
                'facebook_id' => $this->facebook_id,
                'twitter_id' => $this->twitter_id,
                'linkedin_id' => $this->linkedin_id,
                'ssc_equivalent' => $this->ssc_equivalent,
                'hsc_equivalent' => $this->hsc_equivalent,
                'graduation' => $this->graduation,
                'post_graduation' => $this->post_graduation,
                'ssc_from_school' => $this->ssc_from_school,
                'hsc_from_college' => $this->hsc_from_college,
                'grad_university' => $this->grad_university,
                'post_grad_university' => $this->post_grad_university,
                'professional_certification' => $this->professional_certification,
                'social_afiliation' => $this->social_afiliation,
                'professional_afiliation' => $this->professional_afiliation,
                'habits' => $this->habits,
                'award_achievements' => $this->award_achievements,
                'total_job_experience' => $this->total_job_experience,
            ],
        ];
    }
}
