<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reserva_aula".
 *
 * @property int $id
 * @property int|null $id_aula
 * @property string|null $fh_desde
 * @property string|null $fh_hasta
 * @property string|null $observacion
 *
 * @property Aula $aula
 * @property HorarioMateria[] $horarioMaterias
 * @property Materia[] $materias
 */
class ReservaAula extends \yii\db\ActiveRecord
{
    public $materia_ids = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva_aula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_aula'], 'default', 'value' => null],
            [['id_aula'], 'integer'],
            [['fh_desde', 'fh_hasta'], 'safe'],
            [['observacion'], 'string'],
            [['materia_ids'], 'safe'],
            [['id_aula'], 'exist', 'skipOnError' => true, 'targetClass' => Aula::class, 'targetAttribute' => ['id_aula' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_aula' => 'Aula',
            'fh_desde' => 'Fecha/Hora Desde',
            'fh_hasta' => 'Fecha/Hora Hasta',
            'observacion' => 'Observación',
            'materia_ids' => 'Materias',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->materia_ids = ArrayHelper::getColumn($this->materias, 'id');
    }

    public function beforeSave($insert)
    {
        // Procesar materia_ids para asegurar que sea un array
        if (!empty($this->materia_ids) && !is_array($this->materia_ids)) {
            $this->materia_ids = [$this->materia_ids];
        }
        
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        // Eliminar relaciones anteriores
        HorarioMateria::deleteAll(['id_reserva' => $this->id]);
        
        // Crear nuevas relaciones
        if (!empty($this->materia_ids)) {
            // Asegurar que materia_ids sea un array
            $materiaIds = is_array($this->materia_ids) ? $this->materia_ids : [$this->materia_ids];
            
            foreach ($materiaIds as $materia_id) {
                $horario = new HorarioMateria();
                $horario->id_materia = $materia_id;
                $horario->id_reserva = $this->id;
                $horario->fh_desde = $this->fh_desde;
                $horario->fh_hasta = $this->fh_hasta;
                $horario->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function extraFields()
    {
        return ['aula', 'materias'];
    }

    /**
     * Gets query for [[Aula]].
     *
     * @return \yii\db\ActiveQuery|AulaQuery
     */
    public function getAula()
    {
        return $this->hasOne(Aula::class, ['id' => 'id_aula']);
    }

    /**
     * Gets query for [[HorarioMaterias]].
     *
     * @return \yii\db\ActiveQuery|HorarioMateriaQuery
     */
    public function getHorarioMaterias()
    {
        return $this->hasMany(HorarioMateria::class, ['id_reserva' => 'id']);
    }

    /**
     * Gets query for [[Materias]].
     *
     * @return \yii\db\ActiveQuery|MateriaQuery
     */
    public function getMaterias()
    {
        return $this->hasMany(Materia::class, ['id' => 'id_materia'])->viaTable('horario_materia', ['id_reserva' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservaAulaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaAulaQuery(get_called_class());
    }
}
