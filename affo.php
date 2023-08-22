<?php
class affo {
    private $affo_2018;
    private $affo_2022;
    private $affo_2023;
    private $affo_2024;

    public function __construct($affo_2018, $affo_2022, $affo_2023, $affo_2024) {
        $this->affo_2018 = $affo_2018;
        $this->affo_2022 = $affo_2022;
        $this->affo_2023 = $affo_2023;
        $this->affo_2024 = $affo_2024;
    }

    public function calculate_growth_5y() {
        $growth_5y = array();

        for ($i = 0; $i < count($this->affo_2018); $i++) {
            $growth_5y[] = ($this->affo_2023[$i] / $this->affo_2018[$i] - 1) * 100;
        }

        return $growth_5y;
    }

    public function calculate_growth_current_year() {
        $growth_current_year = array();

        for ($i = 0; $i < count($this->affo_2022); $i++) {
            $growth_current_year[] = ($this->affo_2023[$i] / $this->affo_2022[$i] - 1) * 100;
        }

        return $growth_current_year;
    }

    public function calculate_affo_estimate_2y_fwd() {
        $affo_estimate_2y_fwd = array();

        for ($i = 0; $i < count($this->affo_2023); $i++) {
            $affo_estimate_2y_fwd[] = ($this->affo_2024[$i] / $this->affo_2023[$i] - 1) * 100;
        }

        return $affo_estimate_2y_fwd;
    }
}
?>
