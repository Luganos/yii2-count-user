<?php

namespace lugano\userCounter\models;
use Yii;

/**
 * This is the ActiveQuery class for [[DataTable]].
 *
 * @see DataTable
 */
class TblDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DataTable[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DataTable|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
