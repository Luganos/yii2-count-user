<?php

//namespace app\models;
namespace lugano\userCounter\models;
use Yii;

/**
 * This is the ActiveQuery class for [[TblVisits]].
 *
 * @see TblVisits
 */
class TblVisitsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TblVisits[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TblVisits|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
