<?php
namespace App\Http\Requests\Student;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class StudentRecordUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:6|max:150',

            'adm_no' => [
                'sometimes',
                'nullable',
                'alpha_num',
                'min:3',
                'max:150',
                Rule::unique('student_records', 'adm_no')->ignore($this->route('student')),
            ], 'gender' => 'required|string',
            'year_admitted' => 'sometimes|string',
            'phone' => 'sometimes|nullable|string|min:6|max:20',
            'email' => 'sometimes|nullable|email|max:100|unique:users,email,' . $this->route('student'),
            'photo' => 'sometimes|nullable|image|mimes:jpeg,gif,png,jpg|max:2048',
            'address' => 'required|string|min:6|max:120',
            'bg_id' => 'sometimes|nullable',
            'my_class_id' => 'required',
            'section_id' => 'required',
            'nal_id' => 'required',
            'my_parent_id' => 'sometimes|nullable',
            'dorm_id' => 'sometimes|nullable',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'active' => 'nullable|boolean',
            'pob' => 'sometimes|string|max:255',
            'first_class_id' => 'sometimes|exists:my_classes,id',
            'file' => 'sometimes|file|mimes:pdf|max:2048',

            // بيانات الطالب الشخصية
            'national_id' => 'nullable|string|max:20|unique:student_personal_info,national_id,' . $this->route('student_id') . ',student_id',
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

            // بيانات الوالدين
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

            // الإخوة
            'siblings' => 'nullable|array',
            'siblings.*' => 'exists:users,id',
        ];
    }

    public function attributes()
    {
        return (new StudentRecordCreate)->attributes(); // إعادة استخدام نفس الخصائص





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
        return (new StudentRecordCreate)->messages(); // إعادة استخدام نفس الرسائل





    }
}
