<?php

use Illuminate\Database\Seeder;

use App\Account;
use App\AccountPosition;
use App\Position;
use App\Experience;
use App\Task;

class DigitalFulfillmentAccountPositionsAdjustment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::transaction(function(){
        $artist = Position::where('name', 'Artist')->first();
        $smrAgents = Position::where('name', 'SMR Agents')->first();
        $varAgents = Position::where('name', 'VAR Agents')->first();
        $proofer = Position::where('name', 'Proofer')->first();
        $proofreader = Position::where('name', 'Proofreader')->first();
        $webAdmin = Position::where('name', 'Web Admin')->first();
        $webDesigner = Position::where('name', 'Web Designer')->first();
        $logoDesigner = Position::where('name', 'Logo Designer')->first();
        $qc = Position::where('name', 'QC')->first();
        $webQCPosition = Position::where('name', 'Web QC')->first();
        $urlMigrationAndExpiringDomain = Position::where('name', 'URL Migration and Expiring Domain')->first();
        
        $bau = Account::where('name', 'BAU')->first();
        $preLaunchMods = Account::where('name', 'Pre-Launch Mods')->first();
        $postLaunchMods = Account::where('name', 'Post-Launch Mods')->first();
        $setup = Account::where('name', 'Setup')->first();
        $urlMigration = Account::where('name', 'URL Migration')->first();
        $expiringDomain = Account::where('name', 'Expiring Domain')->first();
        $legacyRevision = Account::where('name', 'Legacy Revision')->first();
        $logisticExecutives = Account::where('name', 'Logistic Executives')->first();
        $webQCAccount = Account::where('name', 'Web QC')->first();
        $proofreading = Account::where('name', 'Proofreading')->first();
        $var1 = Account::where('name', 'VAR1')->first();
        $var2 = Account::where('name', 'VAR2')->first();
        $var3 = Account::where('name', 'VAR3')->first();

        // BAU
        $this->bau(compact('bau', 'artist', 'webDesigner', 'proofer', 'proofreader', 'smrAgents', 'webAdmin', 'qc', 'webQCPosition'));
        $this->preLaunchMods(compact('preLaunchMods', 'proofer', 'proofreader'));
        $this->postLaunchMods(compact('postLaunchMods', 'proofer', 'proofreader'));
        $this->setup(compact('setup', 'artist', 'proofer', 'qc', 'logoDesigner'));
        $this->urlMigration(compact('urlMigration', 'urlMigrationAndExpiringDomain'));
        $this->expiringDomain(compact('expiringDomain', 'urlMigrationAndExpiringDomain'));
        $this->legacyRevision(compact('legacyRevision', 'webDesigner', 'proofer', 'proofreader', 'qc'));
        $this->logisticExecutives(compact('logisticExecutives', 'proofer', 'proofreader', 'qc', 'smrAgents', 'logoDesigner'));
        $this->var1(compact('var1', 'varAgents'));
        $this->var2(compact('var2', 'varAgents'));
        $this->var3(compact('var3', 'varAgents'));
        $this->proofreading(compact('proofreading', 'proofreader'));
      });
    }

    protected function bau($params)
    {
      extract($params);
      // artist
      $bauArtistsExperiences = Experience::where('account_id', $bau->id)->where('position_id', $artist->id)->get();

      $bauArtistsExperiences->each(function($experience) use($webDesigner){
        $experience->position_id = $webDesigner->id;
        $experience->save();
      });
      AccountPosition::where('account_id', $bau->id)->where('position_id', $artist->id)->delete();

      // proofreader
      $bauProofer = AccountPosition::where('account_id', $bau->id)->where('position_id', $proofer->id)->first();
      $bauProofer->position_id = $proofreader->id;
      $bauProofer->save();

      $bauProoferExperiences = Experience::where('account_id', $bau->id)->where('position_id', $proofer->id)->get();

      $bauProoferExperiences->each(function($experience) use($proofreader){
        $experience->position_id = $proofreader->id;
        $experience->save();
      });

      // web qc
      $bauQC = AccountPosition::where('account_id', $bau->id)->where('position_id', $qc->id)->first();
      $bauQC->position_id = $webQCPosition->id;
      $bauQC->save();

      $bauQCExperiences = Experience::where('account_id', $bau->id)->where('position_id', $qc->id)->get();

      $bauQCExperiences->each(function($experience) use($webQCPosition){
        $experience->position_id = $webQCPosition->id;
        $experience->save();
      });

      // smr agents
      AccountPosition::where('account_id', $bau->id)->where('position_id', $smrAgents->id)->delete();

      Task::where('account_id', $bau->id)->whereHas('experience', function($query) use($smrAgents){
        $query->where('position_id', $smrAgents->id);
      })->delete();

      Experience::where('account_id', $bau->id)->where('position_id', $smrAgents->id)->delete();

      // web admin
      AccountPosition::where('account_id', $bau->id)->where('position_id', $webAdmin->id)->delete();

      Task::where('account_id', $bau->id)->whereHas('experience', function($query) use($webAdmin){
        $query->where('position_id', $webAdmin->id);
      })->delete();

      Experience::where('account_id', $bau->id)->where('position_id', $webAdmin->id)->delete();
    }

    protected function preLaunchMods($params)
    {
      extract($params);

      // proofreader
      $preLaunchModsProofer = AccountPosition::where('account_id', $preLaunchMods->id)->where('position_id', $proofer->id)->first();
      $preLaunchModsProofer->position_id = $proofreader->id;
      $preLaunchModsProofer->save();

      $preLaunchModsProoferExperiences = Experience::where('account_id', $preLaunchMods->id)->where('position_id', $proofer->id)->get();

      $preLaunchModsProoferExperiences->each(function($experience) use($proofreader){
        $experience->position_id = $proofreader->id;
        $experience->save();
      });
    }

    protected function postLaunchMods($params)
    {
      extract($params);

      // proofreader
      $postLaunchModsProofer = AccountPosition::where('account_id', $postLaunchMods->id)->where('position_id', $proofer->id)->first();
      $postLaunchModsProofer->position_id = $proofreader->id;
      $postLaunchModsProofer->save();

      $postLaunchModsProoferExperiences = Experience::where('account_id', $postLaunchMods->id)->where('position_id', $proofer->id)->get();

      $postLaunchModsProoferExperiences->each(function($experience) use($proofreader){
        $experience->position_id = $proofreader->id;
        $experience->save();
      });
    }

    protected function setup($params)
    {
      extract($params);

      // artist
      AccountPosition::where('account_id', $setup->id)->where('position_id', $artist->id)->delete();

      Task::where('account_id', $setup->id)->whereHas('experience', function($query) use($artist){
        $query->where('position_id', $artist->id);
      })->delete();

      Experience::where('account_id', $setup->id)->where('position_id', $artist->id)->delete();

      // proofer
      AccountPosition::where('account_id', $setup->id)->where('position_id', $proofer->id)->delete();

      Task::where('account_id', $setup->id)->whereHas('experience', function($query) use($proofer){
        $query->where('position_id', $proofer->id);
      })->delete();

      Experience::where('account_id', $setup->id)->where('position_id', $proofer->id)->delete();

      // qc
      AccountPosition::where('account_id', $setup->id)->where('position_id', $qc->id)->delete();

      Task::where('account_id', $setup->id)->whereHas('experience', function($query) use($qc){
        $query->where('position_id', $qc->id);
      })->delete();

      Experience::where('account_id', $setup->id)->where('position_id', $qc->id)->delete();

      // logoDesigner
      AccountPosition::where('account_id', $setup->id)->where('position_id', $logoDesigner->id)->delete();

      Task::where('account_id', $setup->id)->whereHas('experience', function($query) use($logoDesigner){
        $query->where('position_id', $logoDesigner->id);
      })->delete();

      Experience::where('account_id', $setup->id)->where('position_id', $logoDesigner->id)->delete();
    }

    protected function urlMigration($params)
    {
      extract($params);

      AccountPosition::where('account_id', $urlMigration->id)->where('position_id', $urlMigrationAndExpiringDomain->id)->delete();

      Task::where('account_id', $urlMigration->id)->whereHas('experience', function($query) use($urlMigrationAndExpiringDomain){
        $query->where('position_id', $urlMigrationAndExpiringDomain->id);
      })->delete();

      Experience::where('account_id', $urlMigration->id)->where('position_id', $urlMigrationAndExpiringDomain->id)->delete();
    }

    protected function expiringDomain($params)
    {
      extract($params);

      AccountPosition::where('account_id', $expiringDomain->id)->where('position_id', $urlMigrationAndExpiringDomain->id)->delete();

      Task::where('account_id', $expiringDomain->id)->whereHas('experience', function($query) use($urlMigrationAndExpiringDomain){
        $query->where('position_id', $urlMigrationAndExpiringDomain->id);
      })->delete();

      Experience::where('account_id', $expiringDomain->id)->where('position_id', $urlMigrationAndExpiringDomain->id)->delete();
    }

    protected function legacyRevision($params)
    {
      extract($params);

      // proofreader
      $legacyRevisionProofer = AccountPosition::where('account_id', $legacyRevision->id)->where('position_id', $proofer->id)->first();
      $legacyRevisionProofer->position_id = $proofreader->id;
      $legacyRevisionProofer->save();

      $legacyRevisionProoferExperiences = Experience::where('account_id', $legacyRevision->id)->where('position_id', $proofer->id)->get();

      $legacyRevisionProoferExperiences->each(function($experience) use($proofreader){
        $experience->position_id = $proofreader->id;
        $experience->save();
      });

      // qc
      AccountPosition::where('account_id', $legacyRevision->id)->where('position_id', $qc->id)->delete();

      Task::where('account_id', $legacyRevision->id)->whereHas('experience', function($query) use($qc){
        $query->where('position_id', $qc->id);
      })->delete();

      Experience::where('account_id', $legacyRevision->id)->where('position_id', $qc->id)->delete();
    }

    protected function logisticExecutives($params)
    {
      extract($params);

      // proofreader
      $logisticExecutivesProofer = AccountPosition::where('account_id', $logisticExecutives->id)->where('position_id', $proofer->id)->first();
      $logisticExecutivesProofer->position_id = $proofreader->id;
      $logisticExecutivesProofer->save();

      $logisticExecutivesProoferExperiences = Experience::where('account_id', $logisticExecutives->id)->where('position_id', $proofer->id)->get();

      $logisticExecutivesProoferExperiences->each(function($experience) use($proofreader){
        $experience->position_id = $proofreader->id;
        $experience->save();
      });

      // qc
      AccountPosition::where('account_id', $logisticExecutives->id)->where('position_id', $qc->id)->delete();

      Task::where('account_id', $logisticExecutives->id)->whereHas('experience', function($query) use($qc){
        $query->where('position_id', $qc->id);
      })->delete();

      Experience::where('account_id', $logisticExecutives->id)->where('position_id', $qc->id)->delete();

      // smrAgents
      AccountPosition::where('account_id', $logisticExecutives->id)->where('position_id', $smrAgents->id)->delete();

      Task::where('account_id', $logisticExecutives->id)->whereHas('experience', function($query) use($smrAgents){
        $query->where('position_id', $smrAgents->id);
      })->delete();

      Experience::where('account_id', $logisticExecutives->id)->where('position_id', $smrAgents->id)->delete();

      // logoDesigner
      AccountPosition::where('account_id', $logisticExecutives->id)->where('position_id', $logoDesigner->id)->delete();

      Task::where('account_id', $logisticExecutives->id)->whereHas('experience', function($query) use($logoDesigner){
        $query->where('position_id', $logoDesigner->id);
      })->delete();

      Experience::where('account_id', $logisticExecutives->id)->where('position_id', $logoDesigner->id)->delete();
    }

    protected function var1($params)
    {
      extract($params);

      AccountPosition::where('account_id', $var1->id)->whereNotIn('position_id', [$varAgents->id])->delete();

      Task::where('account_id', $var1->id)->whereHas('experience', function($query) use($varAgents){
        $query->whereNotIn('position_id', [$varAgents->id]);
      })->delete();

      Experience::where('account_id', $var1->id)->whereNotIn('position_id', [$varAgents->id])->delete();
    }

    protected function var2($params)
    {
      extract($params);

      AccountPosition::where('account_id', $var2->id)->whereNotIn('position_id', [$varAgents->id])->delete();

      Task::where('account_id', $var2->id)->whereHas('experience', function($query) use($varAgents){
        $query->whereNotIn('position_id', [$varAgents->id]);
      })->delete();

      Experience::where('account_id', $var2->id)->whereNotIn('position_id', [$varAgents->id])->delete();
    }

    protected function var3($params)
    {
      extract($params);

      AccountPosition::where('account_id', $var3->id)->whereNotIn('position_id', [$varAgents->id])->delete();

      Task::where('account_id', $var3->id)->whereHas('experience', function($query) use($varAgents){
        $query->whereNotIn('position_id', [$varAgents->id]);
      })->delete();

      Experience::where('account_id', $var3->id)->whereNotIn('position_id', [$varAgents->id])->delete();
    }

    protected function proofreading($params)
    {
      extract($params);

      AccountPosition::where('account_id', $proofreading->id)->whereNotIn('position_id', [$proofreader->id])->delete();

      Task::where('account_id', $proofreading->id)->whereHas('experience', function($query) use($proofreader){
        $query->whereNotIn('position_id', [$proofreader->id]);
      })->delete();

      Experience::where('account_id', $proofreading->id)->whereNotIn('position_id', [$proofreader->id])->delete();
    }
}
