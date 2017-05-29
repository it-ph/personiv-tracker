<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Position;

class AccountPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
          $artist = Position::where('name', 'Artist')->first()->id;
          $proofer = Position::where('name', 'Proofer')->first()->id;
          $sme = Position::where('name', 'SME')->first()->id;
          $qualityAuditor = Position::where('name', 'Quality Auditor')->first()->id;
          $designProofer = Position::where('name', 'Design Proofer')->first()->id;
          $qc = Position::where('name', 'QC')->first()->id;
          $csr = Position::where('name', 'CSR')->first()->id;
          $webAdminPosition = Position::where('name', 'Web Admin')->first()->id;
          $designer = Position::where('name', 'Designer')->first()->id;
          $editor = Position::where('name', 'Editor')->first()->id;

          $allison = Account::where('name', 'Allison')->first()->id;
          $lamar = Account::where('name', 'Lamar')->first()->id;
          $fDOSoldIncolumn = Account::where('name', 'fDO Sold Incolumn')->first()->id;
          $fDOSoldDisplay = Account::where('name', 'fDO Sold Display')->first()->id;
          $fDOSpecIncolumn = Account::where('name', 'fDO Spec Incolumn')->first()->id;
          $fDOSpecDisplay = Account::where('name', 'fDO Spec Display')->first()->id;
          $fDOAwareness = Account::where('name', 'fDO Awareness')->first()->id;
          $fSMDisplaySpec = Account::where('name', 'fSM Display Spec')->first()->id;
          $fSMIncolumnSpec = Account::where('name', 'fSM Incolumn Spec')->first()->id;
          $fSMDisplaySold = Account::where('name', 'fSM Display Sold')->first()->id;
          $fSMIncolumnSold = Account::where('name', 'fSM Incolumn Sold')->first()->id;
          $fSMAwareness = Account::where('name', 'fSM Awareness')->first()->id;
          $var = Account::where('name', 'VAR')->first()->id;
          $bau = Account::where('name', 'BAU')->first()->id;
          $preLauchMods = Account::where('name', 'Pre-Launch Mods')->first()->id;
          $postLauchMods = Account::where('name', 'Post-Launch Mods')->first()->id;
          $scheduling = Account::where('name', 'Scheduling')->first()->id;
          $boosting = Account::where('name', 'Boosting')->first()->id;
          $setup = Account::where('name', 'Setup')->first()->id;
          $ordering = Account::where('name', 'Ordering')->first()->id;
          $urlMigration = Account::where('name', 'URL Migration')->first()->id;
          $expiringDomain = Account::where('name', 'Expiring Domain')->first()->id;
          $webAdminAccount = Account::where('name', 'Web Admin')->first()->id;
          $legacyRevision = Account::where('name', 'Legacy Revision')->first()->id;
          $logisticExecutives = Account::where('name', 'Logistic Executives')->first()->id;
          $logoDesign = Account::where('name', 'Logo Design')->first()->id;
          $webQC = Account::where('name', 'Web QC')->first()->id;
          $var1 = Account::where('name', 'VAR 1')->first()->id;
          $var2 = Account::where('name', 'VAR 2')->first()->id;
          $var3 = Account::where('name', 'VAR 3')->first()->id;
          $proofreading = Account::where('name', 'Proofreading')->first()->id;
          $revolve = Account::where('name', 'Revolve')->first()->id;

          // Allison
          DB::table('account_positions')->insert([
            [
              'account_id' => $allison,
              'position_id' => $artist,
            ],
            [
              'account_id' => $allison,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $allison,
              'position_id' => $qualityAuditor,
            ],
            [
              'account_id' => $allison,
              'position_id' => $designProofer,
            ],
          ]);
          // lamar
          DB::table('account_positions')->insert([
            [
              'account_id' => $lamar,
              'position_id' => $artist,
            ],
            [
              'account_id' => $lamar,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $lamar,
              'position_id' => $qualityAuditor,
            ],
            [
              'account_id' => $lamar,
              'position_id' => $designProofer,
            ],
          ]);
          // fDO Sold Incolumn
          DB::table('account_positions')->insert([
            [
              'account_id' => $fDOSoldIncolumn,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fDOSoldIncolumn,
              'position_id' => $proofer,
            ],
          ]);
          // fDO Sold Display
          DB::table('account_positions')->insert([
            [
              'account_id' => $fDOSoldDisplay,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fDOSoldDisplay,
              'position_id' => $sme,
            ],
          ]);
          // fDO Spec Incolumn
          DB::table('account_positions')->insert([
            [
              'account_id' => $fDOSpecIncolumn,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fDOSpecIncolumn,
              'position_id' => $sme,
            ],
          ]);
          // fDO Spec Display
          DB::table('account_positions')->insert([
            [
              'account_id' => $fDOSpecDisplay,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fDOSpecDisplay,
              'position_id' => $sme,
            ],
          ]);
          // fDO Awareness
          DB::table('account_positions')->insert([
            [
              'account_id' => $fDOAwareness,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fDOAwareness,
              'position_id' => $proofer,
            ],
          ]);
          // fSM Display Spec
          DB::table('account_positions')->insert([
            [
              'account_id' => $fSMDisplaySpec,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fSMDisplaySpec,
              'position_id' => $proofer,
            ],
          ]);
          // fSM Incolumn Spec
          DB::table('account_positions')->insert([
            [
              'account_id' => $fSMIncolumnSpec,
              'position_id' => $artist,
            ],
          ]);
          // fSM Display Sold
          DB::table('account_positions')->insert([
            [
              'account_id' => $fSMDisplaySold,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fSMDisplaySold,
              'position_id' => $proofer,
            ],
          ]);
          // fSM Incolumn Sold
          DB::table('account_positions')->insert([
            [
              'account_id' => $fSMIncolumnSold,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fSMIncolumnSold,
              'position_id' => $proofer,
            ],
          ]);
          // fSM Awareness
          DB::table('account_positions')->insert([
            [
              'account_id' => $fSMAwareness,
              'position_id' => $artist,
            ],
            [
              'account_id' => $fSMAwareness,
              'position_id' => $proofer,
            ],
          ]);
          // VAR
          DB::table('account_positions')->insert([
            [
              'account_id' => $var,
              'position_id' => $artist,
            ],
          ]);
        });
    }
}
