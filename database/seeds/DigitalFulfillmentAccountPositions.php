<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Experience;
use App\Position;
use App\AccountPosition;

class DigitalFulfillmentAccountPositions extends Seeder
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
        $proofreader = Position::where('name', 'Proofreader')->firstOrFail()->id;
        $sme = Position::where('name', 'SME')->firstOrFail()->id;
        $qc = Position::where('name', 'QC')->firstOrFail()->id;
        $webQCPosition = Position::where('name', 'Web QC')->firstOrFail()->id;
        $urlMigrationAndExpiringDomain = Position::where('name', 'URL Migration and Expiring Domain')->firstOrFail()->id;
        $smrAgents = Position::where('name', 'SMR Agents')->firstOrFail()->id;
        $varAgents = Position::where('name', 'VAR Agents')->firstOrFail()->id;
        $webAdminPosition = Position::where('name', 'Web Admin')->firstOrFail()->id;
        $logoDesigner = Position::where('name', 'Logo Designer')->firstOrFail()->id;
        $webDesigner = Position::where('name', 'Web Designer')->firstOrFail()->id;
        $qualityAuditor = Position::where('name', 'Quality Auditor')->firstOrFail()->id;
        $designProofer = Position::where('name', 'Design Proofer')->firstOrFail()->id;
        $editor = Position::where('name', 'Editor')->firstOrFail()->id;

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
        $webQCAccount = Account::where('name', 'Web QC')->firstOrFail()->id;
        $var1 = Account::where('name', 'VAR1')->firstOrFail()->id;
        $var2 = Account::where('name', 'VAR2')->firstOrFail()->id;
        $var3 = Account::where('name', 'VAR3')->firstOrFail()->id;
        $proofreading = Account::where('name', 'Proofreading')->firstOrFail()->id;

        // Adjustments

        // Bau
        $bau_designer = AccountPosition::where('account_id', $bau)->where('position_id', $logoDesigner)->firstOrFail();
        $bau_designer->position_id = $webDesigner;
        $bau_designer->save();

        $bau_artists_experiences = Experience::where('account_id', $bau)->where('position_id', $artist)->get();
        $bau_artists_experiences->each(function($experience) use($webDesigner){
          $experience->position_id = $webDesigner;
          $experience->save();
        });
        AccountPosition::where('account_id', $bau)->whereNotIn('position_id', [$webDesigner])->delete();
        Experience::where('account_id', $bau)->whereNotIn('position_id', [$webDesigner])->delete();

        // Pre-Launch Mods
        $pre_launch_mods_artist = AccountPosition::where('account_id', $preLauchMods)->where('position_id', $artist)->firstOrFail();
        $pre_launch_mods_artist->position_id = $webDesigner;
        $pre_launch_mods_artist->save();

        $pre_launch_mods_experiences = Experience::where('account_id', $preLauchMods)->where('position_id', $artist)->get();
        $pre_launch_mods_experiences->each(function($experience) use($webDesigner){
          $experience->position_id = $webDesigner;
          $experience->save();
        });
        AccountPosition::where('account_id', $preLauchMods)->whereNotIn('position_id', [$webDesigner])->delete();
        Experience::where('account_id', $preLauchMods)->whereNotIn('position_id', [$webDesigner])->delete();

        // Post-Launch Mods
        $post_launch_mods_artist = AccountPosition::where('account_id', $postLauchMods)->where('position_id', $artist)->firstOrFail();
        $post_launch_mods_artist->position_id = $webDesigner;
        $post_launch_mods_artist->save();

        $post_launch_mods_experiences = Experience::where('account_id', $postLauchMods)->where('position_id', $artist)->get();
        $post_launch_mods_experiences->each(function($experience) use($webDesigner){
          $experience->position_id = $webDesigner;
          $experience->save();
        });
        AccountPosition::where('account_id', $postLauchMods)->whereNotIn('position_id', [$webDesigner])->delete();
        Experience::where('account_id', $postLauchMods)->whereNotIn('position_id', [$webDesigner])->delete();

        // Setup
        AccountPosition::where('account_id', $setup)->whereNotIn('position_id', [$smrAgents])->delete();
        Experience::where('account_id', $setup)->whereNotIn('position_id', [$smrAgents])->delete();

        // URL Migration
        AccountPosition::create([
          'account_id' => $urlMigration,
          'position_id' => $urlMigrationAndExpiringDomain,
        ]);
        AccountPosition::where('account_id', $urlMigration)->whereNotIn('position_id', [$urlMigrationAndExpiringDomain])->delete();
        Experience::where('account_id', $urlMigration)->whereNotIn('position_id', [$urlMigrationAndExpiringDomain])->delete();

        // Expiring Domain
        AccountPosition::create([
          'account_id' => $expiringDomain,
          'position_id' => $urlMigrationAndExpiringDomain,
        ]);
        AccountPosition::where('account_id', $expiringDomain)->whereNotIn('position_id', [$urlMigrationAndExpiringDomain])->delete();
        Experience::where('account_id', $expiringDomain)->whereNotIn('position_id', [$urlMigrationAndExpiringDomain])->delete();

        // Legacy Revision
        $legacy_revision_web_designer = AccountPosition::where('account_id', $legacyRevision)->where('position_id', $artist)->firstOrFail();
        $legacy_revision_web_designer->position_id = $webDesigner;
        $legacy_revision_web_designer->save();

        $legacy_revision_experiences = Experience::where('account_id', $legacyRevision)->where('position_id', $artist)->get();
        $legacy_revision_experiences->each(function($experience) use($webDesigner){
          $experience->position_id = $webDesigner;
          $experience->save();
        });
        AccountPosition::where('account_id', $legacyRevision)->whereNotIn('position_id', [$webDesigner])->delete();
        Experience::where('account_id', $legacyRevision)->whereNotIn('position_id', [$webDesigner])->delete();

        // Logistic Executives
        $logistic_executives_web_designer = AccountPosition::where('account_id', $logisticExecutives)->where('position_id', $artist)->firstOrFail();
        $logistic_executives_web_designer->position_id = $webDesigner;
        $logistic_executives_web_designer->save();

        $logistic_executives_experiences = Experience::where('account_id', $logisticExecutives)->where('position_id', $artist)->get();
        $logistic_executives_experiences->each(function($experience) use($webDesigner){
          $experience->position_id = $webDesigner;
          $experience->save();
        });
        AccountPosition::where('account_id', $logisticExecutives)->whereNotIn('position_id', [$webDesigner])->delete();
        Experience::where('account_id', $logisticExecutives)->whereNotIn('position_id', [$webDesigner])->delete();

        // Web QC
        $web_qc = AccountPosition::where('account_id', $webQCAccount)->where('position_id', $qc)->firstOrFail();
        $web_qc->position_id = $webQCPosition;
        $web_qc->save();

        $web_qc_experiences = Experience::where('account_id', $webQCAccount)->where('position_id', $qc)->get();
        $web_qc_experiences->each(function($experience) use($webQCPosition){
          $experience->position_id = $webQCPosition;
          $experience->save();
        });

        // VAR 1
        $var1_var_agents = AccountPosition::where('account_id', $var1)->where('position_id', $smrAgents)->firstOrFail();
        $var1_var_agents->position_id = $varAgents;
        $var1_var_agents->save();

        $var1_experiences = Experience::where('account_id', $var1)->where('position_id', $artist)->get();
        $var1_experiences->each(function($experience) use($varAgents){
          $experience->position_id = $varAgents;
          $experience->save();
        });
        AccountPosition::where('account_id', $var1)->whereNotIn('position_id', [$varAgents])->delete();
        Experience::where('account_id', $var1)->whereNotIn('position_id', [$varAgents])->delete();

        // VAR 2
        $var2_var_agents = AccountPosition::where('account_id', $var2)->where('position_id', $smrAgents)->firstOrFail();
        $var2_var_agents->position_id = $varAgents;
        $var2_var_agents->save();

        $var2_experiences = Experience::where('account_id', $var2)->where('position_id', $artist)->get();
        $var2_experiences->each(function($experience) use($varAgents){
          $experience->position_id = $varAgents;
          $experience->save();
        });
        AccountPosition::where('account_id', $var2)->whereNotIn('position_id', [$varAgents])->delete();
        Experience::where('account_id', $var2)->whereNotIn('position_id', [$varAgents])->delete();

        // VAR 3
        $var3_var_agents = AccountPosition::where('account_id', $var3)->where('position_id', $smrAgents)->firstOrFail();
        $var3_var_agents->position_id = $varAgents;
        $var3_var_agents->save();

        $var3_experiences = Experience::where('account_id', $var3)->where('position_id', $artist)->get();
        $var3_experiences->each(function($experience) use($varAgents){
          $experience->position_id = $varAgents;
          $experience->save();
        });
        AccountPosition::where('account_id', $var3)->whereNotIn('position_id', [$varAgents])->delete();
        Experience::where('account_id', $var3)->whereNotIn('position_id', [$varAgents])->delete();

        // Proofereader
        $proofreading_proofreader = AccountPosition::where('account_id', $proofreading)->where('position_id', $proofer)->firstOrFail();
        $proofreading_proofreader->position_id = $proofreader;
        $proofreading_proofreader->save();

        $proofreading_experiences = Experience::where('account_id', $proofreading)->where('position_id', $proofer)->get();
        $proofreading_experiences->each(function($experience) use($proofreader){
          $experience->position_id = $proofreader;
          $experience->save();
        });
        AccountPosition::where('account_id', $proofreading)->whereNotIn('position_id', [$proofreader])->delete();
        Experience::where('account_id', $proofreading)->whereNotIn('position_id', [$proofreader])->delete();
      });
    }
}
