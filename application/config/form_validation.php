<?php
$config = array(
    'UC_step1_registration' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[user.email]',
            'errors' => array(
                'required' => '%s required',
                'valid_email' => '%s is not valid',
                'is_unique' => 'This email id is already registered, use a different one.',
            ),
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[5]',
            'errors' => array(
                'required' => '%s required',
                'min_length' => '%s must have 5 character.'
            ),
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'required|matches[password]',
            'errors' => array(
                'required' => '%s required',
                'matches' => 'Password and %s should be same',
            ),
        ),
        array(
            'field' => 'contact_number',
            'label' => 'Contact Number',
            'rules' => 'required|exact_length[10]|numeric',
            'errors' => array(
                'required' => '%s required',
                'exact_length' => 'not a valid mobile number',
                'numeric' => 'not a valid mobile number',
            ),
        )
    ),
    'unique_brand_name' => array(
        array(
            'field' => 'brand_name',
            'label' => 'Brand name',
            'rules' => 'required|is_unique[brand.name]',
            'errors' => array(
                'required' => '%s required',
                'is_unique' => 'This %s is already exist, use a different one.',
            ),
        )
    ),
    'unique_product_name' => array(
        array(
            'field' => 'prd_name',
            'label' => 'Product name',
            'rules' => 'required|is_unique[product.product_name]',
            'errors' => array(
                'required' => '%s required',
                'is_unique' => 'This %s is already exist, use a different one.',
            ),
        )
    )
);