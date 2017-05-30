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
          $artist = Position::where('name', 'Artist')->firstOrFail()->id;
          $proofer = Position::where('name', 'Proofer')->firstOrFail()->id;
          $sme = Position::where('name', 'SME')->firstOrFail()->id;
          $qc = Position::where('name', 'QC')->firstOrFail()->id;
          $csr = Position::where('name', 'CSR')->firstOrFail()->id;
          $webAdminPosition = Position::where('name', 'Web Admin')->firstOrFail()->id;
          $designer = Position::where('name', 'Designer')->firstOrFail()->id;
          $qualityAuditor = Position::where('name', 'Quality Auditor')->firstOrFail()->id;
          $designProofer = Position::where('name', 'Design Proofer')->firstOrFail()->id;
          $editor = Position::where('name', 'Editor')->firstOrFail()->id;

          $allison = Account::where('name', 'Allison')->firstOrFail()->id;
          $lamar = Account::where('name', 'Lamar')->firstOrFail()->id;
          $fDOSoldIncolumn = Account::where('name', 'fDO Sold Incolumn')->firstOrFail()->id;
          $fDOSoldDisplay = Account::where('name', 'fDO Sold Display')->firstOrFail()->id;
          $fDOSpecIncolumn = Account::where('name', 'fDO Spec Incolumn')->firstOrFail()->id;
          $fDOSpecDisplay = Account::where('name', 'fDO Spec Display')->firstOrFail()->id;
          $fDOAwareness = Account::where('name', 'fDO Awareness')->firstOrFail()->id;
          $fSMDisplaySpec = Account::where('name', 'fSM Display Spec')->firstOrFail()->id;
          $fSMIncolumnSpec = Account::where('name', 'fSM Incolumn Spec')->firstOrFail()->id;
          $fSMDisplaySold = Account::where('name', 'fSM Display Sold')->firstOrFail()->id;
          $fSMIncolumnSold = Account::where('name', 'fSM Incolumn Sold')->firstOrFail()->id;
          $fSMAwareness = Account::where('name', 'fSM Awareness')->firstOrFail()->id;
          $var = Account::where('name', 'VAR')->firstOrFail()->id;
          $bau = Account::where('name', 'BAU')->firstOrFail()->id;
          $preLauchMods = Account::where('name', 'Pre-Launch Mods')->firstOrFail()->id;
          $postLauchMods = Account::where('name', 'Post-Launch Mods')->firstOrFail()->id;
          $scheduling = Account::where('name', 'Scheduling')->firstOrFail()->id;
          $boosting = Account::where('name', 'Boosting')->firstOrFail()->id;
          $setup = Account::where('name', 'Setup')->firstOrFail()->id;
          $ordering = Account::where('name', 'Ordering')->firstOrFail()->id;
          $urlMigration = Account::where('name', 'URL Migration')->firstOrFail()->id;
          $expiringDomain = Account::where('name', 'Expiring Domain')->firstOrFail()->id;
          $webAdminAccount = Account::where('name', 'Web Admin')->firstOrFail()->id;
          $legacyRevision = Account::where('name', 'Legacy Revision')->firstOrFail()->id;
          $logisticExecutives = Account::where('name', 'Logistic Executives')->firstOrFail()->id;
          $logoDesign = Account::where('name', 'Logo Design')->firstOrFail()->id;
          $webQC = Account::where('name', 'Web QC')->firstOrFail()->id;
          $var1 = Account::where('name', 'VAR1')->firstOrFail()->id;
          $var2 = Account::where('name', 'VAR2')->firstOrFail()->id;
          $var3 = Account::where('name', 'VAR3')->firstOrFail()->id;
          $proofreading = Account::where('name', 'Proofreading')->firstOrFail()->id;
          $revolve = Account::where('name', 'Revolve')->firstOrFail()->id;

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
          // BAU
          DB::table('account_positions')->insert([
            [
              'account_id' => $bau,
              'position_id' => $artist,
            ],
            [
              'account_id' => $bau,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $bau,
              'position_id' => $qc,
            ],
            [
              'account_id' => $bau,
              'position_id' => $csr,
            ],
            [
              'account_id' => $bau,
              'position_id' => $webAdminPosition,
            ],
            [
              'account_id' => $bau,
              'position_id' => $designer,
            ],
          ]);
          // Pre-launch Mods
          DB::table('account_positions')->insert([
            [
              'account_id' => $preLauchMods,
              'position_id' => $artist,
            ],
            [
              'account_id' => $preLauchMods,
              'position_id' => $proofer,
            ],
          ]);
          // Post-launch Mods
          DB::table('account_positions')->insert([
            [
              'account_id' => $postLauchMods,
              'position_id' => $artist,
            ],
            [
              'account_id' => $postLauchMods,
              'position_id' => $proofer,
            ],
          ]);
          // Scheduling
          DB::table('account_positions')->insert([
            [
              'account_id' => $scheduling,
              'position_id' => $csr,
            ],
          ]);
          // Boosting
          DB::table('account_positions')->insert([
            [
              'account_id' => $boosting,
              'position_id' => $csr,
            ],
          ]);
          // Setup
          DB::table('account_positions')->insert([
            [
              'account_id' => $setup,
              'position_id' => $artist,
            ],
            [
              'account_id' => $setup,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $setup,
              'position_id' => $qc,
            ],
            [
              'account_id' => $setup,
              'position_id' => $csr,
            ],
            [
              'account_id' => $setup,
              'position_id' => $designer,
            ],
          ]);
          // Ordering
          DB::table('account_positions')->insert([
            [
              'account_id' => $ordering,
              'position_id' => $csr,
            ],
          ]);
          // URL Migration
          DB::table('account_positions')->insert([
            [
              'account_id' => $urlMigration,
              'position_id' => $proofer,
            ],
          ]);
          // Expiring Domain
          DB::table('account_positions')->insert([
            [
              'account_id' => $expiringDomain,
              'position_id' => $proofer,
            ],
          ]);
          // Web Admin
          DB::table('account_positions')->insert([
            [
              'account_id' => $webAdminAccount,
              'position_id' => $webAdminPosition,
            ],
          ]);
          // Legacy Revision
          DB::table('account_positions')->insert([
            [
              'account_id' => $legacyRevision,
              'position_id' => $artist,
            ],
            [
              'account_id' => $legacyRevision,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $legacyRevision,
              'position_id' => $qc,
            ],
          ]);
          // Logistic Executives
          DB::table('account_positions')->insert([
            [
              'account_id' => $logisticExecutives,
              'position_id' => $artist,
            ],
            [
              'account_id' => $logisticExecutives,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $logisticExecutives,
              'position_id' => $qc,
            ],
            [
              'account_id' => $logisticExecutives,
              'position_id' => $csr,
            ],
            [
              'account_id' => $logisticExecutives,
              'position_id' => $designer,
            ],
          ]);
          // Logo Design
          DB::table('account_positions')->insert([
            [
              'account_id' => $logoDesign,
              'position_id' => $designer,
            ],
          ]);
          // Web QC
          DB::table('account_positions')->insert([
            [
              'account_id' => $webQC,
              'position_id' => $qc,
            ],
          ]);
          // VAR1
          DB::table('account_positions')->insert([
            [
              'account_id' => $var1,
              'position_id' => $artist,
            ],
            [
              'account_id' => $var1,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $var1,
              'position_id' => $qc,
            ],
            [
              'account_id' => $var1,
              'position_id' => $csr,
            ],
            [
              'account_id' => $var1,
              'position_id' => $designer,
            ],
          ]);
          // VAR2
          DB::table('account_positions')->insert([
            [
              'account_id' => $var2,
              'position_id' => $artist,
            ],
            [
              'account_id' => $var2,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $var2,
              'position_id' => $qc,
            ],
            [
              'account_id' => $var2,
              'position_id' => $csr,
            ],
            [
              'account_id' => $var2,
              'position_id' => $designer,
            ],
          ]);
          // VAR3
          DB::table('account_positions')->insert([
            [
              'account_id' => $var3,
              'position_id' => $artist,
            ],
            [
              'account_id' => $var3,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $var3,
              'position_id' => $qc,
            ],
            [
              'account_id' => $var3,
              'position_id' => $csr,
            ],
            [
              'account_id' => $var3,
              'position_id' => $designer,
            ],
          ]);
          // Proofreading
          DB::table('account_positions')->insert([
            [
              'account_id' => $proofreading,
              'position_id' => $artist,
            ],
            [
              'account_id' => $proofreading,
              'position_id' => $proofer,
            ],
            [
              'account_id' => $proofreading,
              'position_id' => $qc,
            ],
            [
              'account_id' => $proofreading,
              'position_id' => $csr,
            ],
            [
              'account_id' => $proofreading,
              'position_id' => $designer,
            ],
          ]);
          // Revolve
          DB::table('account_positions')->insert([
            [
              'account_id' => $revolve,
              'position_id' => $editor,
            ],
            [
              'account_id' => $revolve,
              'position_id' => $qc,
            ],
          ]);
        });

    }
}
