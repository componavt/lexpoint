<?php

namespace lexpoint;

use Illuminate\Database\Eloquent\Model;

/** 
 * Table lang contains list of languages: name and ID.
 */
class LXLang extends Model {


	protected $connection = 'mysql2';

	protected $table = 'lang';

}
