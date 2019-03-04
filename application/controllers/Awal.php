<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Awal extends CI_Controller {
	var $tbl = 'telepon';
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
	}

	function index(){
		$chart3 = array();
		foreach ($this->db->select('*,count(nomerB) as j')->where('tipe','Voice MO')->group_by('nomerB')->get($this->tbl)->result() as $v) {
			$chart3[$v->nomerB] = $v->j;
		}

		$this->load->view('grafik',array(
			'tabel1' => $this->db->select('nomerB, Waktu, tipe, durasi')->get($this->tbl)->result(),
			'tabel2' => $this->db->select('distinct(nomerB),(select count(nomerB) from telepon) as cb')->get($this->tbl)->result(),
			'chart1' => $this->db->query('select (select count(tipe) from telepon where tipe like "%VAS%") sVs,(select count(tipe) from telepon where tipe like "%SMS%") sS,(select count(tipe) from telepon where tipe like "%Voice MO%") sVoi,((select count(tipe) from telepon where tipe like "%VAS%")/count(nomerB))*100 as VAS, ((select count(tipe) from telepon where tipe like "%SMS%")/count(nomerB))*100 as SMS, ((select count(tipe) from telepon where tipe like "%Voice MO%")/count(nomerB))*100 as VoiceMO, count(tipe) as Sigma from telepon group by nomerA')->result(),
			'chart2' => $this->db->query('select nomerB, count(nomerB) as numB, (count(nomerB)/(select count(nomerA) from telepon group by nomerA))*100 as rate from telepon group by nomerB asc')->result(),
			'chart3' => $chart3,
			'chart4' => $this->getRange()

		));

	}
	function getRange(){
		$d = array(
			'label' => array(' '),
			'dataset' => array([
				'label' => '<<Kosong>>',
	            'data' => array(0),
	            'backgroundColor' => array('white')
			])
		);

		$tgl = array(
			empty($_POST['tgl'][0])?date('Y-m-d'):$_POST['tgl'][0],
			empty($_POST['tgl'][1])?date('Y-m-d'):$_POST['tgl'][1]
		);

		foreach ($this->db->select('*,count(nomerB) as j')->where('Waktu between "'.$tgl[0].'" and "'.$tgl[1].'"')->group_by('nomerB')->get($this->tbl)->result() as $k => $v){
			$d['label'][$k] = $v->nomerB;
			$d['dataset'][$k] = array(
				'label' => $v->nomerB,
				'data' => [intval($v->j)],
				'backgroundColor' => ['rgba('.(rand(100,200)+$v->j).','.(rand(100,200)+$v->j).','.(rand(100,200)+$v->j).',0.6)']
			);
		}
		if(empty($_POST['tgl'])){
			return $d;
		}else{
			echo json_encode($d);
		}
	}

	function ola(){
		?>
		<link href="<?php echo base_url('assets/');?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="<?php echo base_url('assets/bootstrap/js');?>bootstrap.min.js"></script>
		<?php
		$query = $this->db->get('rekam_medis')->result();
		echo '<Table class="table table-responsive">';
		echo '<tr>';
		foreach ($query as $key => $value) {
			echo '<Td>'.$value->kodeRM.'</td>';
		}
		echo '</tr>';
		echo'</Table>';
	}

	function vina(){
		$array = array('1','2','3','4','5','6');
		$i =0;
		$no=0;
		while($i<2){
			$j=0;
			while($j<3){
				$matrix[$i][$j] =$array[$no];
				
				echo $matrix[$i][$j].'|';
				$j++;
				$no++;
			}
			echo '<br>';
			$i++;
		}
		
		$i=0;
		$no=0;
		for ($i=0; $i <3 ; $i++) { 
			for ($j=0; $j <2 ; $j++) { 
				echo $matrix[$j][$i].'|';
			}
			echo '<br>';
		}

		
	}

}
