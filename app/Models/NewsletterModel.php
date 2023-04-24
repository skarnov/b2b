<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsletterModel extends Model
{
    protected $table = 'newsletter';
    protected $primaryKey = 'newsletter_id';
    protected $allowedFields = ['newsletter_email', 'create_time', 'create_date', 'created_by'];
}