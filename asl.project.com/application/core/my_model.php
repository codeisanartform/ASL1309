<?php 
	class MY_Model extends CI_Model{
		const DB_TABLE  = 'abstract';
		const DB_TABLE_PK  = 'abstract';

		/* Create Record */
		private function insert() {
			$this->db->insert($this::DB_TABLE, $this);
			$this->{$this::DB_TABLE_PK} = $this->db->insert_id();
		}

		/* Update Record */
		private function update() {
			$this->db->update($this::DB_TABLE, $this, $this::DB_TABLE_PK);
		}

		/* Populate from an Array or Class | @param mixed $row */
		public function populate($row) {
			foreach ($row as $key => $value) {
				$this->$key = $value;
			}
		}

		/* Loads from the Database | @param :int $id */
		public function load($id) {
			$query = $this->db->get_where($this::DB_TABLE, array($this::DB_TABLE_PK => $id, ));
			$this->populate($query->row());
		}

		/* Delete the current record. */
		public function delete($id) {
			$this->db->delete($this::DB_TABLE, array(
				$this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK},
			));
			unset($this->{$this::DB_TABLE_PK})
		}

		/* Logic to Save or Update */
		public function save() {
			if (isset($this->{$this::DB_TABLE_PK})) {
				$this->update();
			} else {
				$this->insert();
			}
		}

		/* 
		* Get an array of Models with an optional limit, offset.
		* 
		* 
		*/
		public function save() {
			if (isset($this->{$this::DB_TABLE_PK})) {
				$this->update();
			} else {
				$this->insert();
			}
		}
	}
?>