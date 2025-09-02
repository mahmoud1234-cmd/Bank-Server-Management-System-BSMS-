<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model {
    protected $fillable = ['name', 'mode'];

    public function servers() {
        return $this->hasMany(Server::class);
    }
}
?>
