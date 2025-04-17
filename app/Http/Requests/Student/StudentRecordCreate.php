<?php
namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class StudentRecordCreate extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:150',
            'adm_no' => 'sometimes|nullable|alpha_num|min:3|max:150|unique:student_records',
            'gender' => 'string',
            'year_admitted' => 'string',
            'phone' => 'sometimes|nullable|string|min:6|max:20',
            // 'email' => 'sometimes|nullable|email|max:100|unique:users',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,gif,png,jpg|max:2048',
            'address' => 'string|min:6|max:120',
            'bg_id' => 'sometimes|nullable',
            // 'state_id' => '',
            // 'lga_id' => '',
            'nal_id' => '',
            'my_class_id' => '',
            'section_id' => '',
            'my_parent_id' => 'sometimes|nullable',
            'dorm_id' => 'sometimes|nullable',
            'first_name' => ' string|max:255',
            'last_name' => ' string|max:255',
            'active' => 'nullable|boolean',
            'pob' => ' string|max:255',
            'first_class_id' => ' exists:my_classes,id',
            'file' => ' file|mimes:pdf|max:2048', // 2MB max

            
        // 🔹 بيانات الطالب الشخصية (من جدول student_personal_info)
            'national_id' => 'nullable|string|max:20|unique:student_personal_info',
            'form_date' => 'nullable|date',
            'confirmation_date' => 'nullable|date',
            'identified_by' => 'nullable|string|max:255',
            'exception_reason' => 'nullable|string|max:255',
            'withdrawal' => 'nullable|boolean',
            'transfer_school' => 'nullable|string|max:255',
            'withdrawal_date' => 'nullable|date',
            'approved_mobile' => 'nullable|string|max:20',
            'custom_mobile' => 'nullable|string|max:20',
            'kinship' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:255',
            'full_address' => 'nullable|string|max:255',
            'transport_service' => 'nullable|boolean',
            'subscription_type' => 'nullable|string|max:100',
            'transport_group' => 'nullable|string|max:100',
            'registration_place' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:50',
            'national_number' => 'nullable|string|max:50',
            'civil_registry_office' => 'nullable|string|max:255',
            'governorate' => 'nullable|string|max:255',
            'housing_sector' => 'nullable|string|max:255',
            'commitment_behavior_year' => 'nullable|integer|min:2000|max:2099',
            'commitment_academic_year' => 'nullable|integer|min:2000|max:2099',
            'commitment_delay_year' => 'nullable|integer|min:2000|max:2099',
            'commitment_fees_year' => 'nullable|integer|min:2000|max:2099',
            'school_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'health_notes' => 'nullable|string',
            'parent_recommendations' => 'nullable|string',

        // 🔹 بيانات الأب والأم (من جدول parent_info)
            'father_name' => 'nullable|string|max:255',
            'grandfather_name' => 'nullable|string|max:255',
            'father_job' => 'nullable|string|max:255',
            'father_education' => 'nullable|string|max:255',
            'father_workplace' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:20',
            'mother_firstname' => 'nullable|string|max:255',
            'mother_lastname' => 'nullable|string|max:255',
            'grandmother_name' => 'nullable|string|max:255',
            'mother_job' => 'nullable|string|max:255',
            'mother_education' => 'nullable|string|max:255',
            'mother_workplace' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|max:20',
            'father_birth_date' => 'nullable|date',
            'father_nationality' => 'nullable|string|max:100',
            'mother_birth_date' => 'nullable|date',
            'mother_nationality' => 'nullable|string|max:100',
            'separated' => 'nullable|boolean',
            'f_deceased' => 'nullable|boolean',
            'm_deceased' => 'nullable|boolean',

        // 🔹 الإخوة (من جدول siblings)
            'siblings' => 'nullable|array', // يجب أن يكون مصفوفة من الإخوة
            'siblings.*' => 'exists:users,id',
            'rtype' => 'nullable|string',
            'lastschool' => 'nullable|string|max:255',
            'rdocument' => 'nullable|string|max:255',
            'ndocument' => 'nullable|string|max:255',
            'ddocument' => 'nullable|string|max:255',
            'note_register' => 'nullable|string|max:255',
            'certificate_number' => 'nullable|string|max:255',

        ];
    }

    public function attributes()
    {
        return [
            'section_id' => 'Section',
            'nal_id' => 'Nationality',
            'my_class_id' => 'Class',
            'dorm_id' => 'Dormitory',
            // 'state_id' => 'State',
            // 'lga_id' => 'LGA',
            'bg_id' => 'Blood Group',
            'my_parent_id' => 'Parent',
            'national_id' => 'National ID',
            'form_date' => 'Form Date',
            'confirmation_date' => 'Confirmation Date',
            'identified_by' => 'Identified By',
            'exception_reason' => 'Exception Reason',
            'withdrawal' => 'Withdrawal',
            'transfer_school' => 'Transfer School',
            'withdrawal_date' => 'Withdrawal Date',
            'approved_mobile' => 'Approved Mobile',
            'custom_mobile' => 'Custom Mobile',
            'kinship' => 'Kinship',
            'region' => 'Region',
            'full_address' => 'Full Address',
            'transport_service' => 'Transport Service',
            'subscription_type' => 'Subscription Type',
            'transport_group' => 'Transport Group',
            'registration_place' => 'Registration Place',
            'registration_number' => 'Registration Number',
            'national_number' => 'National Number',
            'civil_registry_office' => 'Civil Registry Office',
            'governorate' => 'Governorate',
            'housing_sector' => 'Housing Sector',

        // بيانات الأب والأم
            'father_name' => 'Father Name',
            'grandfather_name' => 'Grandfather Name',
            'father_job' => 'Father Job',
            'father_education' => 'Father Education',
            'father_workplace' => 'Father Workplace',
            'father_phone' => 'Father Phone',
            'mother_firstname' => 'Mother First Name',
            'mother_lastname' => 'Mother Last Name',
            'grandmother_name' => 'Grandmother Name',
            'mother_job' => 'Mother Job',
            'mother_education' => 'Mother Education',
            'mother_workplace' => 'Mother Workplace',
            'mother_phone' => 'Mother Phone',
            'father_birth_date' => 'Father Birth Date',
            'father_nationality' => 'Father Nationality',
            'mother_birth_date' => 'Mother Birth Date',
            'mother_nationality' => 'Mother Nationality',
            'separated' => 'Separated',
            'f_deceased' => 'Father Deceased',
            'm_deceased' => 'Mother Deceased',

        // الإخوة
            'siblings' => 'Siblings',
            'siblings.*' => 'Sibling ID',
        ];
    }

    protected function getValidatorInstance()
    {
        $input = $this->all();

        $input['my_parent_id'] = $input['my_parent_id'] ? Qs::decodeHash($input['my_parent_id']) : NULL;

        $this->getInputSource()->replace($input);

        return parent::getValidatorInstance();
    }
    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'name.min' => 'الاسم يجب أن يكون على الأقل 6 حروف.',
            'name.max' => 'الاسم يجب ألا يتجاوز 150 حرفًا.',

            'adm_no.alpha_num' => 'رقم القيد يجب أن يحتوي فقط على حروف وأرقام.',
            'adm_no.min' => 'رقم القيد يجب أن لا يقل عن 3 حروف.',
            'adm_no.max' => 'رقم القيد يجب ألا يزيد عن 150 حرفًا.',
            'adm_no.unique' => 'رقم القيد مستخدم من قبل.',

            'gender.required' => 'الجنس مطلوب.',
            'year_admitted.required' => 'سنة القبول مطلوبة.',

            'phone.min' => 'رقم الهاتف يجب ألا يقل عن 6 أرقام.',
            'phone.max' => 'رقم الهاتف يجب ألا يزيد عن 20 رقمًا.',

            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.max' => 'البريد الإلكتروني يجب ألا يتجاوز 100 حرف.',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل.',

            'photo.image' => 'الملف يجب أن يكون صورة.',
            'photo.mimes' => 'الصورة يجب أن تكون من نوع jpeg, png, jpg, gif.',
            'photo.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',

            'address.required' => 'العنوان مطلوب.',
            'address.min' => 'العنوان يجب أن يحتوي على 6 أحرف على الأقل.',
            'address.max' => 'العنوان يجب ألا يتجاوز 120 حرفًا.',

            'nal_id.required' => 'الجنسية مطلوبة.',
            'my_class_id.required' => 'الصف مطلوب.',
            'section_id.required' => 'الصف الدراسي مطلوب.',
        ];
    }

}
